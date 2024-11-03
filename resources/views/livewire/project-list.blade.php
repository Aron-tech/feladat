<div>
    <x-success-error-box/>
    <div class="mb-4">
        <div >
            <x-input-label>Szűrés</x-input-label>
            <select wire:change='filterProjects($event.target.value)' class="py-2 bg-gray-800 disabled:text-white text-white rounded-md" name="status">
                <option selected value="all">Összes projekt</option>
                <option value="fejlesztésre vár">Fejlesztésre vár</option>
                <option value="folyamatban">Folyamatban</option>
                <option value="kész">Kész</option>
            </select>
        </div>
    </div>

    <div class="grid gap-4">
        @foreach ($projects as $project)
            <div class="bg-gray-800 p-3 text-white rounded">
                <h3 class="font-semibold">{{ $project->name }}</h3>
                <p class="text-xs text-gray-400">Státusz: {{ $project->status }}</p>
                <p class="text-xs text-gray-400">Kapcsolattartók száma: {{ $project->contactsCount() }}</p>
                <div>
                    <a href="{{ route('projects.edit', $project->id) }}" class="rounded px-2 py-1 bg-blue-600 text-white">Szerkesztés</a>
                    <button wire:click="delete({{ $project->id }})" class= "rounded px-2 py-1 bg-red-600 text-white">Törlés</button>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $projects->links() }}
    </div>
</div>
