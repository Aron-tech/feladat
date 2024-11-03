<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Project;
use App\Models\Contact;

class ContactManager extends Component
{
    public $contacts = [];
    public $project;
    public $all_contact = [];


    public function mount(Project $project)
    {
        $this->project = $project;
        if($project->contacts()->count() > 0) {
            $this->contacts = $this->project->contacts()->get()->map(function ($contact) {
                return [
                    'id' => $contact->id,
                    'name' => $contact->name,
                    'email' => $contact->email,
                ];
            })->toArray();
        }
        $this->all_contact = $this->loadContacts();
    }

    public function selectContact($id){
        $contact = Contact::findOrFail($id);
        $this->contacts[] = [
            'id' => $contact->id,
            'name' => $contact->name,
            'email' => $contact->email,
        ];

    }

    public function loadContacts(){
        return Contact::get();
    }
    public function addContact()
    {
        $this->contacts[] = ['name' => '', 'email' => ''];
    }

    public function updateContact($id, $index)
    {
        $this->validate([
            'contacts.'. $index . '.name' => 'required|string|max:255',
            'contacts.' . $index . '.email' => 'email|unique:contacts,email,' . $id,
        ]);
        $contact =  Contact::findOrFail($id);
        $contact->update([
            'name' => $this->contacts[$index]['name'],
            'email' => $this->contacts[$index]['email'],
        ]);
        $this->all_contact = $this->loadContacts();
    }

    public function deleteContact($index, $id = null)
    {
        unset($this->contacts[$index]);
        $this->contacts = array_values($this->contacts);

        if (isset($id) && isset($this->project->id)) {
            $project = Project::findOrFail($this->project->id);
            $project->contacts()->detach($id);
        }
    }
    public function render()
    {
        return view('livewire.contact-manager');
    }
}
