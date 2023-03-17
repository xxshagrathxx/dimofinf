<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;

use Carbon\Carbon;

use DataTables;
use Image;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Currency::get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function($row){
                    return $row->name;
                })
                ->addColumn('symbol', function($row){
                    return $row->symbol;
                })
                ->addColumn('code', function($row){
                    return $row->code;
                })
                ->addColumn('conversion', function($row){
                    $conversionRate = currencyConversion(1, 'EGP', $row->code);
                    return $conversionRate;
                })
                ->addColumn('primary', function($row){
                    if($row->primary == 1)
                        return '<span class="btn btn-success btn-rounded btn-fw">Yes</span>';
                    else
                        return '<span class="btn btn-danger btn-rounded btn-fw">No</span>';
                })
                // ->addColumn('action', function($row){
                //     $actionBtn = '<a href="'.route('product.show', $row->id).'" class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></a>
                //                     <a href="'.route('product.edit', $row->id).'" class="btn btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                //                     <a href="'.route('product.destroy', $row->id).'" id="delete" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                //     return $actionBtn;
                // })
                ->rawColumns(['name', 'symbol', 'code', 'primary'])
                ->make(true);
        }

        return view('pages.currency.list_currencies');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
