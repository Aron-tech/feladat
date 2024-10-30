<div class="pt-2 space-y-2">
    <x-input-label>Kapcsolattartók</x-input-label>
    @foreach($contacts as $index => $contact)
        <div class="flex items-center space-x-2">
            <input type="text"  name="contacts_name[]" wire:model="contacts.{{ $index }}.name" placeholder="Név" class="w-1/2 p-2 bg-gray-500 text-black rounded-md">
            <input type="email" name="contacts_email[]" wire:model="contacts.{{ $index }}.email" placeholder="Email" class="w-1/2 p-2 bg-gray-500 text-black rounded-md">
            <button type="button" wire:click="deleteContact({{ $index }})" class="text-red-500">Törlés</button>
        </div>
    @endforeach
    <button type="button" wire:click="addContact()" class="mt-2 px-4 py-2 bg-blue-600 rounded">Kapcsolattartó hozzáadása</button>
</div>
