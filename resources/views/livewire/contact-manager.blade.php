<div class="pt-2 space-y-2">
    <x-success-error-box/>
    <x-input-label>Kapcsolattartók</x-input-label>
    <select class="py-2 bg-gray-500  text-black rounded-md" name="selectContact" wire:model='default_select' wire:change='selectContact($event.target.value)'>
        <option disabled:text-black value="" disabled selected>Válassz kapcsolattartót</option>
        @foreach($all_contact as $this_contact)
            <option value="{{ $this_contact->id }}">{{ $this_contact->name }} - {{ $this_contact->email }}</option>
        @endforeach
    </select>
    @foreach($contacts as $index => $contact)
        <div class="flex items-center space-x-2">
            <input type="text" @if(isset($contact['id'])) wire:change='updateContact({{$contact['id']}}, {{ $index }})' @endif name="contacts_name[]" wire:model="contacts.{{ $index }}.name" placeholder="Név" class="w-1/2 p-2 bg-gray-500 text-black rounded-md">
            <input type="email" @if(isset($contact['id'])) wire:change='updateContact({{$contact['id']}}, {{ $index }})' @endif name="contacts_email[]" wire:model="contacts.{{ $index }}.email" placeholder="Email" class="w-1/2 p-2 bg-gray-500 text-black rounded-md">
            <button type="button" wire:click="deleteContact({{ $index }}, {{ $contact['id'] ?? ''}})" wire:loading.attr='disabled' class="text-red-500">Törlés</button>
        </div>  
    @endforeach
    <button type="button" wire:click="addContact()" class="mt-2 px-4 py-2 bg-blue-600 rounded">Kapcsolattartó hozzáadása</button>
</div>
