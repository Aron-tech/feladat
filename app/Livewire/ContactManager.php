<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Project;
use App\Models\Contact;

class ContactManager extends Component
{
    public $contacts = [];
    public $project;


    public function mount(Project $project)
    {
        $this->project = $project;
        if($project->contacts()->count() > 0) {
            $this->contacts = $this->project->contacts()->get()->map(function ($contact) {
                return [
                    'name' => $contact->name,
                    'email' => $contact->email,
                ];
            })->toArray();
        }
    }
    public function addContact()
    {
        $this->contacts[] = ['name' => '', 'email' => ''];
    }

    public function deleteContact($index)
    {
        unset($this->contacts[$index]);
        $this->contacts = array_values($this->contacts);
    }
    public function render()
    {
        return view('livewire.contact-manager');
    }
}
