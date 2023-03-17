@extends('layouts.main')

@section('title')
    {{ __('users.list_title') }}
@endsection

@section('content')
    <h1>Create User</h1>

    <br>

    <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label class="form-label" for="name">Name<span class="is-required"> (*)</span></label>
            <input type="text" name="name" class="form-control" placeholder="Enter Name ..." value="{{ old('name') }}">
            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="password">Password<span class="is-required"> (*)</span></label>
            <input type="password" name="password" class="form-control" placeholder="Enter Password ...">
            @error('password')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="password_confirmation">Confirm Password<span class="is-required"> (*)</span></label>
            <input type="password" name="password_confirmation" class="form-control" placeholder="Enter Confirm Password ...">
            @error('password_confirmation')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="email">Email<span class="is-required"> (*)</span></label>
            <input type="text" name="email" class="form-control" placeholder="Enter Email ..." value="{{ old('email') }}">
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="role_id">Role<span class="is-required"> (*)</span></label>
            <select class="form-control" name="role_id" required>
                <option value="" selected="" disabled="">Choose Role</option>
                @foreach($roles as $role)
                    @php if(Auth::user()->role_id == 2 && $role->id == 1) // Where admins cannot add super admins
                        continue;
                    @endphp
                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->role }}</option>
                @endforeach
            </select>
            @error('role_id')
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

        <button type="submit" class="btn btn-primary btn-pills">Save</button>
        <a href=" {{url()->previous() }}" class="btn btn-dark btn-pills">Back</a>
    </form>
@endsection
