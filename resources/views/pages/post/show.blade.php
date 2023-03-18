@extends('layouts.main')

@section('title')
    Show Post
@endsection

@section('styles')
    <style>
        .card {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            max-width: 400px;
            margin: auto;
            text-align: center;
            font-family: arial;
            border-radius: 5px;
            padding: 30px;
        }

        .price {
            color: #f00;
            font-size: 22px;
            padding: 10px
        }

        .card button {
            border: none;
            outline: 0;
            padding: 12px;
            color: white;
            background-color: #000;
            text-align: center;
            cursor: pointer;
            width: 100%;
            font-size: 18px;
        }

        img {
            border-radius: 30px;
            padding: 15px;
        }

        .description {
            text-align: justify;
        }
    </style>
@endsection

@section('content')
    <h2 style="text-align:center">{{ $post->title }}</h2>

    <div class="card">
        <img src="{{ asset($post->image) }}" alt="Image" style="width:100%">
        Created by: <h1>{{ $post->user->name }}</h1>
        <p class="price">Phone: {{ $post->phone }}</p>
        <p class="description">Description: {!! $post->description !!}</p>

        <hr>

        <form action="{{ route('post.upload.image') }}" method="post" enctype="multipart/form-data">
            @csrf
    
            {{-- <input type="hidden" name="old_image" value="{{ $post->image }}"> --}}
            <input type="hidden" name="post_id" value="{{ $post->id }}">
    
            <div class="form-group">
                <label for="image" class="form-label">Upload Image</label>
                <input type="file" name="image">
                <button type="submit" class="btn" style="padding: 10px; margin: 10px 0px; width: 50%">Upload Image</button>
                @error('image')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </form>
    </div>
@endsection
