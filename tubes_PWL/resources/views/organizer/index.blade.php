@extends('layouts.app')

@section('content')
<h2>Organizer List</h2>

<a href="/organizer/create" class="btn btn-primary mb-3">Add Organizer</a>

<table class="table table-bordered">
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

    @foreach($organizers as $org)
    <tr>
        <td>{{ $org->name }}</td>
        <td>{{ $org->email }}</td>
        <td>{{ $org->status }}</td>
        <td>
            <a href="/organizer/edit/{{ $org->id }}" class="btn btn-warning">Edit</a>

            <form action="/organizer/toggle/{{ $org->id }}" method="POST" style="display:inline">
                @csrf
                <button class="btn btn-secondary">Toggle</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
@endsection