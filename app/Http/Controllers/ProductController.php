<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Imports\ProductsImport;

use Illuminate\Support\Str;
use Carbon\Carbon;
use Response;
use Excel;

use DataTables;
use Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::with('category')->latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('refrence_no', function($row){
                    return $row->refrence_no;
                })
                ->addColumn('name', function($row){
                    return $row->name;
                })
                ->addColumn('category_id', function($row){
                    return $row->category->name;
                })
                // ->addColumn('description', function($row){
                //     return Str::limit(strip_tags($row->description), 50, '...');
                // })
                ->addColumn('image', function($row){
                    if (str_contains($row->image, 'upload'))
                        $image = '<img src="'.asset($row->image).'" style="width: 50px; height: 50px; border-radius: 50%" alt="'.asset($row->image).'" />';
                    else
                        $image = '<img src="'.asset('default_imgs/default_product.jpg').'" style="width: 50px; height: 50px; border-radius: 50%" alt="Image" />';
                    return $image;
                })
                ->addColumn('cost_price', function($row){
                    return $row->cost_price;
                })
                ->addColumn('sale_price', function($row){
                    return $row->sale_price;
                })
                ->addColumn('updated_at', function($row){
                    return $row->updated_at->diffForHumans();
                })
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="'.route('product.show', $row->id).'" class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                    <a href="'.route('product.edit', $row->id).'" class="btn btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                    <a href="'.route('product.destroy', $row->id).'" id="delete" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['name', 'description', 'category_id', 'image', 'cost_price', 'sale_price', 'updated_at', 'action'])
                ->make(true);
        }

        return view('pages.product.list_products');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::get();
        return view('pages.product.create', compact('categories'));
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
            'refrence_no' => 'required',
            'category_id' => 'required',
            'sale_price' => 'required|numeric',
            'image' => 'mimes:jpeg,png,jpg,webp,gif,svg|max:2048',
    	],[
    		'name.required' => 'This field is required',
            'refrence_no.required' => 'This field is required',
            'category_id.required' => 'This field is required',
    		'sale_price.required' => 'This field is required',
            'sale_price.numeric' => 'This field must be digits only',
            'image.mimes' => 'This field must be an image',
            'image.max' => 'Max size for image is 2 MB',
    	]);

        $save_url = 'default_imgs/default_product.jpg';

        if($request->file('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(300,300)->save('uploads/products/'.$name_gen);
            $save_url = 'uploads/products/'.$name_gen;
        }

        Product::create([
            'refrence_no' => $request->refrence_no,
            'name' => $request->name,
            'description' => $request->description,
            'image' => $save_url,
            'cost_price' => $request->cost_price,
            'sale_price' => $request->sale_price,
            'category_id' => $request->category_id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

	    $notification = array(
			'message' => 'Product saved successfully !!',
			'alert-type' => 'success'
		);

		return redirect()->route('product.view')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        return view('pages.product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::get();
        $product = Product::findOrFail($id);
        return view('pages.product.edit', compact('product', 'categories'));
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
            'refrence_no' => 'required',
            'category_id' => 'required',
            'sale_price' => 'required|numeric',
            'image' => 'mimes:jpeg,png,jpg,webp,gif,svg|max:2048',
    	],[
    		'name.required' => 'This field is required',
            'refrence_no.required' => 'This field is required',
            'category_id.required' => 'This field is required',
    		'sale_price.required' => 'This field is required',
            'sale_price.numeric' => 'This field must be digits only',
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
            Image::make($image)->resize(300,300)->save('uploads/products/'.$name_gen);
            $save_url = 'uploads/products/'.$name_gen;

            Product::findOrFail($id)->update([
                'refrence_no' => $request->refrence_no,
                'name' => $request->name,
                'description' => $request->description,
                'image' => $save_url,
                'cost_price' => $request->cost_price,
                'sale_price' => $request->sale_price,
                'category_id' => $request->category_id,
                'updated_at' => Carbon::now(),
            ]);
        } else {
            Product::findOrFail($id)->update([
                'refrence_no' => $request->refrence_no,
                'name' => $request->name,
                'description' => $request->description,
                'cost_price' => $request->cost_price,
                'sale_price' => $request->sale_price,
                'category_id' => $request->category_id,
                'updated_at' => Carbon::now(),
            ]);
        }

        $notification = array(
            'message' => 'Product updated successfully !!',
            'alert-type' => 'success'
        );

        return redirect()->route('product.view')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
    	$img = $product->image;
        if (str_contains($img, 'upload'))
            unlink($img);
    	$product->delete();

    	 $notification = array(
			'message' => 'Product deleted Successfully !!',
			'alert-type' => 'info'
		);

		return redirect()->back()->with($notification);
    }

    public function excelView()
    {
        return view('pages.product.excel.view');
    }

    public function excelDownload()
    {
        $path = storage_path().'/'.'app'.'/files/'.'product.xlsx';
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

        Excel::import(new ProductsImport, $request->import);

        $notification = array(
            'message' => 'Products imported successfully !!',
            'alert-type' => 'success'
        );

        return redirect()->route('product.view')->with($notification);
    }
}
