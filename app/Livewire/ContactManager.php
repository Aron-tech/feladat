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
    public $default_select ="";


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

        $this->all_contact = $this->loadContacts();

        $this->default_select = "";

    }

    public function loadContacts(){

        $ids=[];

        foreach($this->contacts as $act_contact){
             $ids[] = $act_contact['id'];
        }

        return Contact::whereNotIn('id', $ids)->orderBy('name')->get();
    }
    public function addContact()
    {
        $this->contacts[] = ['name' => '', 'email' => ''];
    }

    public function updateContact($id, $index)
    {
        $contacts = $this->validate([
            'contacts.'. $index . '.name' => 'required|string|max:255',
            'contacts.' . $index . '.email' => 'email|unique:contacts,email,' . $id,
        ]);
        $contact =  Contact::findOrFail($id);
        $contact->update([
            'name' => $this->contacts[$index]['name'],
            'email' => $this->contacts[$index]['email'],
        ]);

    }

    public function deleteContact($index, $id = null)
    {
        if(sizeof($this->contacts) <= 1) {
            return session()->flash('error', 'Sikertelen törlés, minimum egy kapcsolattartót megkell adni.');
        }
        unset($this->contacts[$index]);
        $this->contacts = array_values($this->contacts);

        if (isset($id) && isset($this->project->id)) {
            $project = Project::findOrFail($this->project->id);
            $project->contacts()->detach($id);
        }
        session()->flash('success', 'Sikeres törlés.');

        $this->all_contact = $this->loadContacts();
    }
    public function render()
    {
        return view('livewire.contact-manager');
    }
}
