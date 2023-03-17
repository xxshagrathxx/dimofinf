@extends('layouts.main')

@section('title')
    Edit Customer
@endsection

@section('content')
    <h1>Edit Customer</h1>

    <br>

    <form action="{{ route('customer.update', $customer->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="old_image" value="{{ $customer->image }}">

        <div class="form-group">
            <label class="form-label" for="name">Customer Name<span class="is-required"> (*)</span></label>
            <input type="text" name="name" class="form-control" placeholder="Enter Customer Name ..." value="{{ old('name', $customer->name) }}">
            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="phone">Phone<span class="is-required"> (*)</span></label>
            <input type="text" name="phone" class="form-control" placeholder="Enter Phone ..." onkeypress="return isNumberKey(event)" value="{{ old('phone', $customer->phone) }}">
            @error('phone')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="email">Email</label>
            <input type="text" name="email" class="form-control" placeholder="Enter Email ..." value="{{ old('email', $customer->email) }}">
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="address">Address</label>
            <textarea class="form-control" name="address" id="ckeditor" rows="115">{{ old('address', $customer->address) }}</textarea>
            @error('address')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="image">Image</label>
            <input type="file" name="image" id="image">
            @error('image')
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
