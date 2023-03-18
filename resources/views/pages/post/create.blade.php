@extends('layouts.main')

@section('title')
    Create Post
@endsection

@section('content')
    <h1>Create Post</h1>

    <br>

    <form action="{{ route('post.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label class="form-label" for="title">Title<span class="is-required"> (*)</span></label>
            <input type="text" name="title" class="form-control" placeholder="Enter Post Title ..." value="{{ old('title') }}">
            @error('title')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="description">Description<span class="is-required"> (*)</span></label>
            <textarea class="form-control" name="description" id="ckeditor" rows="115">{{ old('description') }}</textarea>
            @error('description')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div id="word-count"></div>

        <div class="form-group">
            <label class="form-label" for="phone">Phone<span class="is-required"> (*)</span></label>
            <input type="text" name="phone" class="form-control" placeholder="Enter Contact Phone ..." onkeypress="return isNumberKey(event)" value="{{ old('phone') }}">
            @error('phone')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary btn-pills">Save</button>
        <a href=" {{url()->previous() }}" class="btn btn-dark btn-pills">Back</a>
    </form>
@endsection

@section('scripts_bot')
    <script>
        ClassicEditor
            .create( document.querySelector( '#ckeditor' ), {

            })
            .then( ckeditor => {
                const wordCountPlugin = editor.plugins.get( 'WordCount' );
                const wordCountWrapper = document.getElementById( 'word-count' );

                wordCountWrapper.appendChild( wordCountPlugin.wordCountContainer );
            } )
            .catch( error => {
                console.error( error );
            } );
    </script>

@endsection
