<h1>{{ $project->name }} projekt módosítva lett</h1>
<p>Következő adatok módosultak:</p>
<ul>
    @foreach($changedData as $key => $value)
        <li><strong>{{ ucfirst($key) }}:</strong> {{ $value }}</li>
    @endforeach
</ul>
<p>Üdvözlettel,<br>A Projektkezelő Rendszer</p>
