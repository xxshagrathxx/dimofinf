@extends('layouts.main')

@section('title')
Import Categories
@endsection

@section('content')
    <h1>Import Categories</h1>

    <br>

    <div class="card">
        <div class="card-body">
            <h3 style="padding: 80px 10px">Here you can import all the categories, Please download the sample file and <b style="color: #f00">DON'T DELETE THE FIRST ROW</b>
                <br><br><a class="btn btn-warning" href="{{ route('category.excel.download') }}">Download Sample File</a>
            </h3>

            <hr>
            <form action="{{ route('category.excel.import') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <input type="file" name="import" class="form-control">
                    @error('import')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary btn-pills">Save</button>
                <a href=" {{url()->previous() }}" class="btn btn-dark btn-pills">Back</a>
            </form>
        </div>
    </div>
@endsection
