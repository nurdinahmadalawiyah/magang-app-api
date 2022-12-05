<?php

namespace App\Http\Controllers;

use App\Models\SourceScraping;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;

class ScraperController extends Controller
{
    public function prosple()
    {   
        $url = 'https://id.prosple.com/search-jobs?opportunity_types=2&locations=9714%2C9714%7C24768&defaults_applied=1&study_fields=502';
        
        $goutteClient = new Client(HttpClient::create(['timeout' => 60, 'verify_peer' => base_path('prosple-cert.crt')]));

        $crawler = $goutteClient->request('GET', $url);
        $data = $crawler->filter("li[class='SearchResultsstyle__SearchResult-sc-c560t5-1 hlOmzw']")->each(function ($node) {
            return [
                'id' => Str::random(10),
                'position' => $node->filter("a[class='JobTeaserstyle__JobTeaserTitleLink-sc-1p2iccb-2 eiICbF']")->text(),
                'company' => $node->filter("header[class='Teaser__TeaserHeader-sc-129e2mv-1 JobTeaserstyle__JobTeaserHeader-sc-1p2iccb-1 iBnwQU bycdHT']")->text(),
                'image' => $node->filter("img[src]")->attr('src'),
                'link' => 'https://id.prosple.com'.$node->filter("a[href]")->attr('href'),
                'source' => 'Prosple'
            ];
        });

        return response()->json([
            "message" => "Scraping from prosple",
            "status" => "Success",
            "data" => $data
        ]);
    }

    public function prospleStoreDb()
    {   
        $url = 'https://id.prosple.com/search-jobs?opportunity_types=2&locations=9714%2C9714%7C24768&defaults_applied=1&study_fields=502';
        
        $goutteClient = new Client(HttpClient::create(['timeout' => 60, 'verify_peer' => base_path('prosple-cert.crt')]));

        $crawler = $goutteClient->request('GET', $url);
        $data = $crawler->filter("li[class='SearchResultsstyle__SearchResult-sc-c560t5-1 hlOmzw']")->each(function ($node) {
            return [
                // 'id' => Str::random(10),
                'position' => $node->filter("a[class='JobTeaserstyle__JobTeaserTitleLink-sc-1p2iccb-2 eiICbF']")->text(),
                // 'description' => $node->filter("div[data-testid='raw-html']")->text(),
                'company' => $node->filter("header[class='Teaser__TeaserHeader-sc-129e2mv-1 JobTeaserstyle__JobTeaserHeader-sc-1p2iccb-1 iBnwQU bycdHT']")->text(),
                'image' => $node->filter("img[src]")->attr('src'),
                // 'location' => $node->filter("div[class='sc-gsTCUz JobTeaserstyle__JobLocation-sc-1p2iccb-8 hAURsc jOLgFK']")->text(),
                'link' => 'https://id.prosple.com'.$node->filter("a[href]")->attr('href'),
                'source' => 'Prosple'
            ];
        });

        foreach($data as $data)
        {
            SourceScraping::create($data);
        }

        return response()->json([
            "message" => "Scraping from prosple",
            "status" => "Success",
            "data" => $data
        ]);
    }

    public function glints()
    {   
        $url = 'https://glints.com/id/en/opportunities/jobs/explore?keyword=Informatika%2C+Programmer&country=ID&searchCity=29367&locationName=Bandung%2C+Indonesia&jobTypes=INTERNSHIP';
        
        $goutteClient = new Client(HttpClient::create(['timeout' => 60, 'verify_peer' => base_path('glints-cert.crt')]));

        $crawler = $goutteClient->request('GET', $url);
        $data = $crawler->filter("div[class='JobCardsc__JobcardContainer-sc-1f9hdu8-0 hvpJwO CompactOpportunityCardsc__CompactJobCardWrapper-sc-1y4v110-0 dLzoMG compact_job_card']")->each(function ($node) {
            return [
                'id' => Str::random(10),
                'position' => $node->filter("h2[class='CompactOpportunityCardsc__JobTitle-sc-1y4v110-7 cYZbCX']")->text(),
                'company' => $node->filter("a[class='CompactOpportunityCardsc__CompanyLink-sc-1y4v110-8 kCzMph']")->text(),
                'image' => $node->filter("img[src]")->attr('src'),
                'link' => 'https://glints.com'.$node->filter("a[href]")->attr('href'),
                'source' => 'Glints'
            ];
        });

        return response()->json([
            "message" => "Scraping from glints",
            "status" => "Success",
            "data" => $data
        ]);
    }
}
