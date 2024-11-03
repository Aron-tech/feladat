<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Project;

class ProjectList extends Component
{

    private $projects;

    private function loadProjects()
    {
        return Project::with('contacts')->simplePaginate(10);
    }
    public function mount()
    {
        $this->projects = $this->loadProjects();
    }

    public function filterProjects($status)
    {
        if($status != 'all') {
            $this->projects = Project::with('contacts')->where('status', $status)->simplePaginate(10);
        }else {
            $this->projects = $this->loadProjects();
        }

    }

    public function delete($id)
    {
        $project = Project::findOrFail($id);

        $project->delete();

        $this->projects = $this->loadProjects();

        session()->flash('success', 'A projekt sikeresen törölve.');
    }

    public function render()
    {

        return view('livewire.project-list', ['projects' => $this->projects]);
    }
}
