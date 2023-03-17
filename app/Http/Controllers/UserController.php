<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Carbon\Carbon;

use DataTables;

use Image;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::latest()->where('id', '!=', 1)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function($row){
                    return $row->name;
                })
                ->addColumn('image', function($row){
                    if (str_contains($row->profile_photo_path, 'upload'))
                        $image = '<img src="'.asset($row->profile_photo_path).'" style="width: 50px; height: 50px; border-radius: 50%" alt="'.asset($row->profile_photo_path).'" />';
                    else
                        $image = '<img src="'.asset('default_imgs/default_avatar.png').'" style="width: 50px; height: 50px; border-radius: 50%" alt="Image" />';
                    return $image;
                })
                ->addColumn('email', function($row){
                    return $row->email;
                })
                ->addColumn('updated_at', function($row){
                    return $row->updated_at->diffForHumans();
                })
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="'.route('user.show', $row->id).'" class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                    <a href="'.route('user.edit', $row->id).'" class="btn btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                    <a href="'.route('user.destroy', $row->id).'" id="delete" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['name', 'image', 'email', 'address', 'updated_at', 'action'])
                ->make(true);
        }

        return view('pages.user.list_users');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::get();
        return view('pages.user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
    		'name' => 'required',
    		'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8',
            'email' => 'required|email',
            'role_id' => 'required',
            'image' => 'mimes:jpeg,png,jpg,webp,gif,svg|max:2048',
    	],[
    		'name.required' => 'This field is required',
            'password.required' => 'This field is required',
            'password.min' => 'This field must be 8 characters or more',
            'password.confirmed' => 'Passwords must match',
            'password_confirmation.required' => 'This field is required',
            'password_confirmation.min' => 'This field must be 8 characters or more',
            'email.required' => 'This field is required',
            'email.email' => 'Please enter a valid email',
            'role_id.required' => 'This field is required',
            'image.mimes' => 'This field must be an image',
            'image.max' => 'Max size for image is 2 MB',
    	]);

        $save_url = 'default_imgs/default_avatar.png';

        if($request->file('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(300,300)->save('uploads/users/'.$name_gen);
            $save_url = 'uploads/users/'.$name_gen;
        }

        User::create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'email' => $request->email,
            'role_id' => $request->role_id,
            'profile_photo_path' => $save_url,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

	    $notification = array(
			'message' => 'User saved successfully !!',
			'alert-type' => 'success'
		);

		return redirect()->route('user.view')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('pages.user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::get();
        return view('pages.user.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
    		'name' => 'required',
    		'password' => 'confirmed',
            'email' => 'required|email',
            'role_id' => 'required',
            'image' => 'mimes:jpeg,png,jpg,webp,gif,svg|max:2048',
    	],[
    		'name.required' => 'This field is required',
            'password.confirmed' => 'Passwords must match',
            'email.required' => 'This field is required',
            'email.email' => 'Please enter a valid email',
            'role_id.required' => 'This field is required',
            'image.mimes' => 'This field must be an image',
            'image.max' => 'Max size for image is 2 MB',
    	]);

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
                User::findOrFail($id)->update([
                    'name' => $request->name,
                    'password' => Hash::make($request->password),
                    'email' => $request->email,
                    'role_id' => $request->role_id,
                    'profile_photo_path' => $save_url,
                    'updated_at' => Carbon::now(),
                ]);
            } else {
                User::findOrFail($id)->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'role_id' => $request->role_id,
                    'profile_photo_path' => $save_url,
                    'updated_at' => Carbon::now(),
                ]);
            }
        } else {
            if(!empty($request->password)) {
                User::findOrFail($id)->update([
                    'name' => $request->name,
                    'password' => Hash::make($request->password),
                    'email' => $request->email,
                    'role_id' => $request->role_id,
                    'updated_at' => Carbon::now(),
                ]);
            } else {
                User::findOrFail($id)->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'role_id' => $request->role_id,
                    'updated_at' => Carbon::now(),
                ]);
            }
        }

        $notification = array(
            'message' => 'User updated successfully !!',
            'alert-type' => 'success'
        );

        return redirect()->route('user.view')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
    	$img = $user->profile_photo_path;
        if (str_contains($img, 'upload'))
            unlink($img);
    	$user->delete();

    	 $notification = array(
			'message' => 'User deleted Successfully !!',
			'alert-type' => 'info'
		);

		return redirect()->back()->with($notification);
    }
}
