@extends('layouts.main')

@section('title')
    Show User
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
    <h2 style="text-align:center">{{ $user->name }}</h2>

    <div class="card">
        <img src="{{ asset($user->profile_photo_path) }}" alt="Image" style="width:100%">
        <p class="description">Email: {{ $user->email }}</p>
    </div>
@endsection
