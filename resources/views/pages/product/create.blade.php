@extends('layouts.main')

@section('title')
    {{ __('products.list_title') }}
@endsection

@section('content')
    <h1>Create Product</h1>

    <br>

    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label class="form-label" for="refrence_no">Item Number<span class="is-required"> (*)</span></label>
            <input type="text" name="refrence_no" class="form-control" placeholder="Enter Item Number ..." value="{{ old('refrence_no') }}">
            @error('refrence_no')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="name">Product Name<span class="is-required"> (*)</span></label>
            <input type="text" name="name" class="form-control" placeholder="Enter Product Name ..." value="{{ old('name') }}">
            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="category_id">Category<span class="is-required"> (*)</span></label>
            <select class="form-control" name="category_id" required>
                <option value="" selected="" disabled="">Choose Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="description">Description</label>
            <textarea class="form-control" name="description" id="ckeditor" rows="115">{{ old('description') }}</textarea>
            @error('description')
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

        <div class="form-group">
            <label class="form-label" for="cost_price">Cost Price</label>
            <input type="text" name="cost_price" class="form-control" placeholder="Enter Cost Price ..." onkeypress="return isNumberKey(event)" value="{{ old('cost_price') }}">
            @error('cost_price')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="sale_price">Sale Price<span class="is-required"> (*)</span></label>
            <input type="text" name="sale_price" class="form-control" placeholder="Enter Sale Price ..." onkeypress="return isNumberKey(event)" value="{{ old('sale_price') }}">
            @error('sale_price')
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
            .create( document.querySelector( '#ckeditor' ) )
            .catch( error => {
                console.error( error );
            } );
    </script>

@endsection
