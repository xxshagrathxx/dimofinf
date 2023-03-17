<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\user;

use Carbon\Carbon;
use Image;

use Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('pages.user-profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
    		'name' => 'required',
    		'password' => 'confirmed',
            'email' => 'required|email',
            'image' => 'mimes:jpeg,png,jpg,webp,gif,svg|max:2048',
    	],[
    		'name.required' => 'This field is required',
            'password.confirmed' => 'Passwords must match',
            'email.required' => 'This field is required',
            'email.email' => 'Please enter a valid email',
            'image.mimes' => 'This field must be an image',
            'image.max' => 'Max size for image is 2 MB',
    	]);

        $userId = $request->userId;
        $old_img = $request->old_image;

        $save_url = '';

        if($request->file('image')) {
            if(str_contains($old_img, 'upload'))
                unlink($old_img);
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(300,300)->save('uploads/users/'.$name_gen);
            $save_url = 'uploads/users/'.$name_gen;

            if(!empty($request->password)) {
                User::findOrFail($userId)->update([
                    'name' => $request->name,
                    'password' => Hash::make($request->password),
                    'email' => $request->email,
                    'profile_photo_path' => $save_url,
                    'updated_at' => Carbon::now(),
                ]);
            } else {
                User::findOrFail($userId)->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'profile_photo_path' => $save_url,
                    'updated_at' => Carbon::now(),
                ]);
            }
        } else {
            if(!empty($request->password)) {
                User::findOrFail($userId)->update([
                    'name' => $request->name,
                    'password' => Hash::make($request->password),
                    'email' => $request->email,
                    'updated_at' => Carbon::now(),
                ]);
            } else {
                User::findOrFail($userId)->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'updated_at' => Carbon::now(),
                ]);
            }
        }

        $notification = array(
            'message' => 'Profile updated successfully !!',
            'alert-type' => 'success'
        );

        return redirect()->route('profile.edit')->with($notification);
    }
}
