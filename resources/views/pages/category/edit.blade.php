@extends('layouts.main')

@section('title')
    Edit Category
@endsection

@section('content')
    <h1>Edit Category</h1>

    <br>

    <form action="{{ route('category.update', $category->id) }}" method="POST">
        @csrf

        <div class="form-group">
            <label class="form-label" for="name">Category Name<span class="is-required"> (*)</span></label>
            <input type="text" name="name" class="form-control" placeholder="Enter Category Name ..." value="{{ old('name', $category->name) }}">
            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary btn-pills">Update</button>
        <a href=" {{url()->previous() }}" class="btn btn-dark btn-pills">Back</a>
    </form>
@endsection
