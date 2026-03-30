@extends('layouts.app')

@section('content')
<h2>Add Organizer</h2>

<form method="POST" action="/organizer/store">
    @csrf
    <input type="text" name="name" placeholder="Name" class="form-control mb-2">
    <input type="email" name="email" placeholder="Email" class="form-control mb-2">
    <input type="password" name="password" placeholder="Password" class="form-control mb-2">

    <button class="btn btn-success">Save</button>
</form>
@endsection