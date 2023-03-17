<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Imports\CustomersImport;

use Carbon\Carbon;
use Response;
use Excel;

use DataTables;
use Image;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Customer::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function($row){
                    return $row->name;
                })
                ->addColumn('phone', function($row){
                    return $row->phone;
                })
                ->addColumn('email', function($row){
                    return $row->email;
                })
                ->addColumn('image', function($row){
                    if (str_contains($row->image, 'upload'))
                        $image = '<img src="'.asset($row->image).'" style="width: 50px; height: 50px; border-radius: 50%" alt="'.asset($row->image).'" />';
                    else
                        $image = '<img src="'.asset('default_imgs/default_avatar.png').'" style="width: 50px; height: 50px; border-radius: 50%" alt="Image" />';
                    return $image;
                })
                ->addColumn('updated_at', function($row){
                    return $row->updated_at->diffForHumans();
                })
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="'.route('customer.show', $row->id).'" class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                    <a href="'.route('customer.edit', $row->id).'" class="btn btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                    <a href="'.route('customer.destroy', $row->id).'" id="delete" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['name', 'phone', 'email', 'image', 'updated_at', 'action'])
                ->make(true);
        }

        return view('pages.customer.list_customer');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.customer.create');
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
            'phone' => 'required|unique:customers,phone|digits_between:11,11',
            'email' => 'email',
            'image' => 'mimes:jpeg,png,jpg,webp,gif,svg|max:2048',
    	],[
    		'name.required' => 'This field is required',
            'phone.required' => 'This field is required',
            'phone.unique' => 'This phone already Exists !!',
            'phone.digits_between' => 'Phone number must be 11 digits',
            'email.email' => 'Please enter a valid email',
            'image.mimes' => 'This field must be an image',
            'image.max' => 'Max size for image is 2 MB',
    	]);

        $save_url = 'default_imgs/default_avatar.png';

        if($request->file('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(300,300)->save('uploads/customers/'.$name_gen);
            $save_url = 'uploads/customers/'.$name_gen;
        }

        Customer::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'image' => $save_url,
            'address' => $request->address,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

	    $notification = array(
			'message' => 'Customer saved successfully !!',
			'alert-type' => 'success'
		);

		return redirect()->route('customer.view')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        return view('pages.customer.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('pages.customer.edit', compact('customer'));
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
            'phone' => 'required|unique:customers,phone,'.$id.'|digits_between:11,11',
            'email' => 'email',
            'image' => 'mimes:jpeg,png,jpg,webp,gif,svg|max:2048',
    	],[
    		'name.required' => 'This field is required',
            'phone.required' => 'This field is required',
            'phone.unique' => 'This phone already Exists !!',
            'phone.digits_between' => 'Phone number must be 11 digits',
            'email.email' => 'Please enter a valid email',
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
            Image::make($image)->resize(300,300)->save('uploads/customers/'.$name_gen);
            $save_url = 'uploads/customers/'.$name_gen;

            Customer::findOrFail($id)->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'image' => $save_url,
                'address' => $request->address,
                'updated_at' => Carbon::now(),
            ]);
        } else {
            Customer::findOrFail($id)->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'updated_at' => Carbon::now(),
            ]);
        }

        $notification = array(
            'message' => 'Customer updated successfully !!',
            'alert-type' => 'success'
        );

        return redirect()->route('customer.view')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
    	$img = $customer->image;
        if (str_contains($img, 'upload'))
            unlink($img);
    	$customer->delete();

    	 $notification = array(
			'message' => 'Customer deleted Successfully !!',
			'alert-type' => 'info'
		);

		return redirect()->back()->with($notification);
    }

    public function excelView()
    {
        return view('pages.customer.excel.view');
    }

    public function excelDownload()
    {
        $path = storage_path().'/'.'app'.'/files/'.'customer.xlsx';
        if (file_exists($path)) {
            return Response::download($path);
        }
    }

    public function excelImport(Request $request)
    {
        $request->validate([
            'import' => 'mimes:xlsx|max:20048',
    	],[
            'import.mimes' => 'This field must be an Excel file',
            'import.max' => 'Max size for the file is 20 MB',
    	]);

        Excel::import(new CustomersImport, $request->import);

        $notification = array(
            'message' => 'Customers imported successfully !!',
            'alert-type' => 'success'
        );

        return redirect()->route('customer.view')->with($notification);
    }
}
