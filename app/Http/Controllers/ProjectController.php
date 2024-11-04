<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Mail;

use App\Mail\ProjectUpdated;

class ProjectController extends Controller
{
    public function index()
    {
        return view('projects.index');
    }

    public function create()
    {
        return view('projects.edit');
    }

    public function edit(Project $project){
        return view('projects.edit', compact('project'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|string|in:fejlesztésre vár,folyamatban,kész',
            'contacts_name' => 'required|array|min:1',
            'contacts_email' => 'required|array|min:1',
            'contacts_name.*' => 'string|max:255',
            'contacts_email.*' => 'email|unique:contacts,email',
        ]);

        $project = Project::create($request->only('name', 'description', 'status'));

        for ($i = 0; $i < count($request->contacts_name); $i++) {
            $contacts[$i]['name'] = $request->contacts_name[$i];
            $contacts[$i]['email'] = $request->contacts_email[$i];
        }
            //dd($contacts);
            $project->contacts()->createMany((array) $contacts);

       /* foreach ($request->contacts_name as $key => $name) {
            $project->contacts()->create([
                'name' => $name,
                'email' => $request->contacts_email[$key],
            ]);
        }
        1 contact / 1 query
        */

        return redirect()->route('projects.index')->with('success', 'Projekt sikeresen létrehozva.');
    }

    public function update(Request $request, Project $project)
{

    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'status' => 'required|string|in:fejlesztésre vár,folyamatban,kész',
        'contacts_name' => 'required|array|min:1',
        'contacts_email' => 'required|array|min:1',
        'contacts_name.*' => 'string|max:255',
        'contacts_email.*' => 'email',
    ]);
    $oldData = $project->only(['name', 'description', 'status']);

    $project->update($request->only('name', 'description', 'status'));

    $changedData = array_diff_assoc($request->only(['name', 'description', 'status']), $oldData);

    if (!empty($changedData)) {
        foreach ($project->contacts as $contact) {
          Mail::to($contact->email)->queue(new ProjectUpdated($project, $changedData));
        }
    }
        foreach ($request->contacts_name as $key => $name) {

            $contact = $project->contacts()->firstOrCreate([
                'email' => $request->contacts_email[$key]],
                [
                'name' => $name,
            ]);
        }
        return redirect()->route('projects.index')->with('success', 'Projekt sikeresen frissítve.');
}

}
