@extends('layouts.main')

@section('title')
    Edit Post
@endsection

@section('content')
    <h1>Edit Post</h1>

    <br>

    <form action="{{ route('post.update', $post->id) }}" method="POST">
        @csrf

        <div class="form-group">
            <label class="form-label" for="title">Title<span class="is-required"> (*)</span></label>
            <input type="text" name="title" class="form-control" placeholder="Enter Item Number ..." value="{{ old('title', $post->title) }}">
            @error('title')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="description">Description<span class="is-required"> (*)</span></label>
            <textarea class="form-control" name="description" id="ckeditor" rows="115">{{ old('description', $post->description) }}</textarea>
            @error('description')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div id="word-count"></div>

        <div class="form-group">
            <label class="form-label" for="phone">Phone<span class="is-required"> (*)</span></label>
            <input type="text" name="phone" class="form-control" placeholder="Enter Contact Phone ..." onkeypress="return isNumberKey(event)" value="{{ old('phone', $post->phone) }}">
            @error('phone')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary btn-pills">Update</button>
        <a href=" {{url()->previous() }}" class="btn btn-dark btn-pills">Back</a>
    </form>
@endsection

@section('scripts_bot')
    <script>
        ClassicEditor
            .create( document.querySelector( '#ckeditor' ) )
            .catch( error => {
                console.error( error );
            } );
    </script>

@endsection
