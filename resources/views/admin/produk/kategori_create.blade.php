@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create Category</h1>

        <form action="{{ route('kategori.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Category Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Create</button>
        </form>
    </div>
@endsection
