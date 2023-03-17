@extends('layouts.main')

@section('title')
Create Category
@endsection

@section('content')
    <h1>Create Category</h1>

    <br>

    <form action="{{ route('category.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label class="form-label" for="name">Category Name<span class="is-required"> (*)</span></label>
            <input type="text" name="name" class="form-control" placeholder="Enter Category Name ..." value="{{ old('name') }}">
            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary btn-pills">Save</button>
        <a href=" {{url()->previous() }}" class="btn btn-dark btn-pills">Back</a>
    </form>
@endsection