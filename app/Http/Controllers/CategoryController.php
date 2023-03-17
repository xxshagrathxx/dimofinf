<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Imports\CategoriesImport;

use Carbon\Carbon;
use Response;
use Excel;

use DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function($row){
                    return $row->name;
                })
                ->addColumn('updated_at', function($row){
                    return $row->updated_at->diffForHumans();
                })
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="'.route('category.edit', $row->id).'" class="btn btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                    <a href="'.route('category.destroy', $row->id).'" id="delete" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['name', 'updated_at', 'action'])
                ->make(true);
        }

        return view('pages.category.list_categories');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.category.create');
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
    	],[
    		'name.required' => 'This field is required',
    	]);

        Category::create([
            'name' => $request->name,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

	    $notification = array(
			'message' => 'Category saved successfully !!',
			'alert-type' => 'success'
		);

		return redirect()->route('category.view')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('pages.category.edit', compact('category'));
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
    	],[
    		'name.required' => 'This field is required',
    	]);

        Category::findOrFail($id)->update([
            'name' => $request->name,
            'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Catrgory updated successfully !!',
            'alert-type' => 'success'
        );

        return redirect()->route('category.view')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
    	$category->delete();

    	 $notification = array(
			'message' => 'Category deleted Successfully !!',
			'alert-type' => 'info'
		);

		return redirect()->back()->with($notification);
    }

    public function excelView()
    {
        return view('pages.category.excel.view');
    }

    public function excelDownload()
    {
        $path = storage_path().'/'.'app'.'/files/'.'category.xlsx';
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

        Excel::import(new CategoriesImport, $request->import);

        $notification = array(
            'message' => 'Catrgories imported successfully !!',
            'alert-type' => 'success'
        );

        return redirect()->route('category.view')->with($notification);
    }
}
