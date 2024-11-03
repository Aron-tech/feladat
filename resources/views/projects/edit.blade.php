<x-app>
    <x-slot:title>
        {{ $project->exists ? $project->name . ' - szerkesztése' : 'Projekt létrehozása' }}
    </x-slot:title>

    <h1 class="text-3xl font-semibold text-white">{{ $project->exists ? $project->name : 'Projekt létehozása' }}</h1>
    <form method="POST" action="{{ $project->exists ? route('projects.update', $project->id) : route('projects.store') }}">
        @csrf
        @if($project->exists)
            @method('PUT')
        @endif
        <div>
            <x-input-label>Név</x-input-label>
            <input type="text" name="name" value="{{ old('name', $project->name) }}" class="w-full p-3 bg-gray-500 text-black rounded-lg transition-colors duration-300 focus:border-blue-500 focus:ring focus:ring-blue-300 focus:outline-none" placeholder="Add meg a projekt nevét" required>
        </div>

        <div>
            <x-input-label>Leírás</x-input-label>
            <textarea name="description" class="w-full p-3 bg-gray-500 text-black rounded-lg transition-colors duration-300 focus:border-blue-500 focus:ring focus:ring-blue-300 focus:outline-none" placeholder="Add meg a projekt leírását" required>{{ old('description', $project->description) }}</textarea>
        </div>

        <div>
            <x-input-label>Státusz</x-input-label>
            <select name="status" class="w-full p-3 bg-gray-500 text-black rounded-lg transition-colors duration-300 focus:border-blue-500 focus:ring focus:ring-blue-300 focus:outline-none" required>
                <option value="fejlesztésre vár" {{ $project->status == 'fejlesztésre vár' ? 'selected' : '' }}>Fejlesztésre vár</option>
                <option value="folyamatban" {{ $project->status == 'folyamatban' ? 'selected' : '' }}>Folyamatban</option>
                <option value="kész" {{ $project->status == 'kész' ? 'selected' : '' }}>Kész</option>
            </select>
        </div>

        <livewire:contact-manager :project="$project"/>
        <div class="py-5">
            <button type="submit" class="w-full p-3 bg-green-600 rounded-lg hover:bg-green-700 transition duration-300">Mentés</button>
        </div>
    </form>
</x-app>
