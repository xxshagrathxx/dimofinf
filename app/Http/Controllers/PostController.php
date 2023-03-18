<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

use Illuminate\Support\Str;
use Carbon\Carbon;
use Response;

use DataTables;
use Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Post::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('title', function($row){
                    return $row->title;
                })
                ->addColumn('description', function($row){
                    return Str::limit(strip_tags($row->description), 70, '...');
                })
                ->addColumn('phone', function($row){
                    return $row->phone;
                })
                ->addColumn('user_id', function($row){
                    return $row->user->name;
                })
                ->addColumn('action', function($row){
                    if(Auth::user()->id == $row->user_id) {
                        $actionBtn = '<a href="'.route('post.show', $row->id).'" class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                        <a href="'.route('post.edit', $row->id).'" class="btn btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                        <a href="'.route('post.destroy', $row->id).'" id="delete" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                    } else {
                        $actionBtn = '<a href="'.route('post.show', $row->id).'" class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                    }

                    return $actionBtn;
                })
                ->rawColumns(['title', 'description', 'phone', 'user_id', 'action'])
                ->make(true);
        }

        return view('pages.post.list_posts');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.post.create');
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
    		'title' => 'required',
            'description' => 'required|max:2048',
            'phone' => 'required',
    	],[
    		'title.required' => 'This field is required',
            'description.required' => 'This field is required',
            'description.max' => 'This field max size is 2 KB',
            'phone.required' => 'This field is required',
    	]);

        Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'phone' => $request->phone,
            'user_id' => Auth::user()->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

	    $notification = array(
			'message' => 'Post saved successfully !!',
			'alert-type' => 'success'
		);

		return redirect()->route('post.view')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('pages.post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('pages.post.edit', compact('post'));
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
    		'title' => 'required',
            'description' => 'required',
            'phone' => 'required',
    	],[
    		'title.required' => 'This field is required',
            'description.required' => 'This field is required',
            'phone.required' => 'This field is required',
    	]);

        $post = Post::findOrFail($id);

        if(Auth::user()->id == $post->user_id) {
            $post->update([
                'title' => $request->title,
                'description' => $request->description,
                'phone' => $request->phone,
                'updated_at' => Carbon::now(),
            ]);
        } else {
            $notification = array(
                'message' => 'You are not authorized to edit this post !!',
                'alert-type' => 'error'
            );
    
            return redirect()->route('post.view')->with($notification);
        }

        $notification = array(
            'message' => 'Post updated successfully !!',
            'alert-type' => 'success'
        );

        return redirect()->route('post.view')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if(Auth::user()->id != $post->user_id) {
            $notification = array(
                'message' => 'You are not authorized to delete this post !!',
                'alert-type' => 'error'
            );
    
            return redirect()->back()->with($notification);
        }

        $post->delete();

    	$notification = array(
			'message' => 'Post deleted Successfully !!',
			'alert-type' => 'info'
		);

		return redirect()->back()->with($notification);
    }
}
