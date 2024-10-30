<div>
    <div class="mb-4">
        <div>
            <button wire:click="filterProjects('all')" class="rounded px-3 py-1 bg-gray-700 text-white">Összes projekt</button>
            <button wire:click="filterProjects('fejlesztésre vár')" class="rounded px-3 py-1 bg-gray-700 text-white">Fejlesztésre vár</button>
            <button wire:click="filterProjects('folyamatban')" class="rounded px-3 py-1 bg-gray-700 text-white">Folyamatban</button>
            <button wire:click="filterProjects('kész')" class="rounded px-3 py-1 bg-gray-700 text-white">Kész</button>
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
