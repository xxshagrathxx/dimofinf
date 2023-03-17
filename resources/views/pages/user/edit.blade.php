@extends('layouts.main')

@section('title')
    Edit User
@endsection

@section('content')
    <h1>Edit User</h1>

    <br>

    <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="old_image" value="{{ $user->profile_photo_path }}">

        <div class="form-group">
            <label class="form-label" for="name">Name<span class="is-required"> (*)</span></label>
            <input type="text" name="name" class="form-control" placeholder="Enter Name ..." value="{{ old('name', $user->name) }}">
            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <hr>
        <h3 style="color: #4d83ff">If you didn't enter a password, Old password will remain</h3>
        <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Enter Password ...">
            @error('password')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" placeholder="Enter Confirm Password ...">
            @error('password_confirmation')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <hr>

        <div class="form-group">
            <label class="form-label" for="email">Email<span class="is-required"> (*)</span></label>
            <input type="text" name="email" class="form-control" placeholder="Enter Email ..." value="{{ old('email', $user->email) }}">
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
                    <option value="{{ $role->id }}" {{ $role->id == old('role_id', $user->role_id) ? 'selected' : '' }}>{{ $role->role }}</option>
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

        <button type="submit" class="btn btn-primary btn-pills">Update</button>
        <a href=" {{url()->previous() }}" class="btn btn-dark btn-pills">Back</a>
    </form>
@endsection
