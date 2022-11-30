<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\SourceScrapingResource;
use App\Models\SourceScraping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class SourceScrapingController extends Controller
{
    public function index()
    {
        $data = SourceScraping::all();

        return (SourceScrapingResource::collection($data));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'source' => 'required|string|max:255',
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'url' => 'required'
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors());
        }

        $file = $request->file('image');
        $destinationPath = "public\images";
        $filename = 'source_scrapings_' . date("Ymd_his") . '.' . $file->extension();
        $sourceScraping = SourceScraping::create([
            'source' => $request->source,
            'image' => $filename,
            'url' => $request->url
        ]);
        Storage::putFileAs($destinationPath, $file, $filename);

        return (new SourceScrapingResource($sourceScraping));
    }

    public function update(Request $request, SourceScraping $sourceScraping)
    {
        $validator = Validator::make($request->all(), [
            'source' => 'required|string|max:255',
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'url' => 'required'
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors());
        }

        if($request->hasFile('image')) {
            $file = $request->file('image');
            $destinationPath = "public\images";
            $filename = 'source_scrapings_' . date("Ymd_his") . '.' . $file->extension();
            Storage::putFileAs($destinationPath, $file, $filename);

            Storage::delete('public/images/' . $sourceScraping->image);

            $sourceScraping->update([
                'source' => $request->source,
                'image' => $filename,
                'url' => $request->url
            ]);
        } else {
            $sourceScraping->update([
                'source' => $request->source,
                'url' => $request->url,
            ]);
        }

        return (new SourceScrapingResource($sourceScraping));
    }

    public function destroy(SourceScraping $sourceScraping)
    {
        $sourceScraping->delete();
        Storage::delete('public/images/' . $sourceScraping->image);

        return response()->json(['Data Deleted successfully.']);
    }
}
