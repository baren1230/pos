@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Category</h1>

        <form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Category Name</label>
                <input type="text" name="name" id="name" class="form-control"
                    value="{{ old('name', $kategori->name) }}" required>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Update</button>
        </form>
    </div>
@endsection
