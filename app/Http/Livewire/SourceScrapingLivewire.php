<?php

namespace App\Http\Livewire;

use App\Models\SourceScraping;
use Livewire\Component;

class SourceScrapingLivewire extends Component
{
    public $source_scraping, $position, $company, $image, $link, $source_scraping_id;
    public $isModalOpen = 0;

    public function render()
    {
        $this->source_scraping = SourceScraping::all();
        return view('livewire.source-scraping-livewire');
    }

    public function create()
    {
        $this->resetCreateForm();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    private function resetCreateForm()
    {
        $this->position = '';
        $this->company = '';
        $this->image = '';
        $this->link = '';
    }

    public function store()
    {
        $this->validate([
            'position' => 'required',
            'company' => 'required',
            'image' => 'required',
            'link' => 'required',
        ]);

        SourceScraping::updateOrCreate(['id' => $this->source_scraping_id], [
            'position' => $this->position,
            'company' => $this->company,
            'image' => $this->image,
            'link' => $this->link,
        ]);

        session()->flash('message', $this->source_scraping_id ? 'Data updated successfully' : 'Data added successfully');

        $this->closeModal();
        $this->resetCreateForm();
    }

    public function edit($id)
    {
        $source_scraping = SourceScraping::findOrFail($id);
        $this->source_scraping_id = $id;
        $this->position = $source_scraping->position;
        $this->company = $source_scraping->company;
        $this->image = $source_scraping->image;
        $this->link = $source_scraping->link;

        $this->openModal();
    }

    public function delete($id)
    {
        SourceScraping::find($id)->delete();
        session()->flash('message', 'Data deleted successfully');
    }
}
