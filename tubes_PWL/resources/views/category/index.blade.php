@extends('layouts.app')

@section('content')
<h2>Category List</h2>

<form method="POST" action="/category/store">
    @csrf
    <input type="text" name="kategori" placeholder="New Category" class="form-control mb-2">
    <button class="btn btn-primary">Add</button>
</form>

<table class="table mt-3">
    @foreach($categories as $cat)
    <tr>
        <td>{{ $cat->kategori }}</td>
        <td>
            <form action="/category/delete/{{ $cat->kategori }}" method="POST">
                @csrf
                <button class="btn btn-danger">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
@endsection