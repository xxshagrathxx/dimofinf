<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Quotation;
use Carbon\Carbon;
use DataTables;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Redirect,Response;

class QuotationContoller extends Controller
{
    public function index()
   {
        $products = Product::get();
        $currencies = Currency::get();
        $customers = Customer::get();
        return view('pages.quotation.index', compact('products','currencies', 'customers'));
   }

   public function getPrice()
   {
        $getPrice = $_GET['id'];
        $price  = Product::where('id', $getPrice)->get();
        // dd(Response::json($price));
        return Response::json($price);
   }

   public function store(Request $request)
   {
        $reqArr = $request->table;

        $customer = $reqArr[0];
        $currency = $reqArr[1];

        unset($reqArr[0]);
        unset($reqArr[1]);

        $productIds = "";
        $quantities = "";

        foreach ($reqArr as $key => $value) {
            $productIds .= $value[1] . "|";
            $quantities .= $value[3] . "|";
        }

        $productIds = substr($productIds, 0, -1);
        $quantities = substr($quantities, 0, -1);

        Quotation::create([
            'quotation_ref_no' => date('Ymd-His'),
            'product_id_arr' => $productIds,
            'quantity_arr' => $quantities,
            'customer_id' => $customer,
            'currency_id' => $currency,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return redirect()->route('user.view');
   }

   public function listAllQuotations(Request $request)
   {
        if ($request->ajax()) {
            $data = Quotation::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('quotation_ref_no', function($row){
                    return $row->quotation_ref_no;
                })
                ->addColumn('customer_id', function($row){
                    return $row->customer->name;
                })
                ->addColumn('currency_id', function($row){
                    return $row->currency->code;
                })
                ->addColumn('status', function($row){
                    if($row->status == "Completed")
                        return '<span style="padding: 5px" class="btn btn-success btn-rounded btn-fw">Completed</span>';
                    else
                        return '<span style="padding: 5px" class="btn btn-warning btn-rounded btn-fw">Pending</span>';
                })
                ->addColumn('created_by', function($row){
                    return $row->user->name;
                })
                ->addColumn('updated_at', function($row){
                    return $row->updated_at->diffForHumans();
                })
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="'.route('quotation.show', $row->id).'" class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                    <a href="'.route('quotation.destroy', $row->id).'" id="delete" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['quotation_ref_no', 'customer_id', 'currency_id', 'status', 'created_by', 'updated_at', 'action'])
                ->make(true);
        }

        return view('pages.quotation.list_quotations');
    }

    public function show($id)
    {
        $quotation = Quotation::with('customer')->findOrFail($id);

        $productNames = array();
        $productPrices = array();
        $resultArr = array();

        $productIds = explode("|", $quotation->product_id_arr);
        foreach($productIds as $key => $pId) {
            $product = Product::where('id', $pId)->first();
            $productName = $product->name;
            $productPrice = $product->sale_price;
            array_push($productNames, $productName);
            array_push($productPrices, $productPrice);
        }

        $quantities = explode("|", $quotation->quantity_arr);

        for ($i = 0; $i < count($productIds); $i++) {
            $resultArr[$i] = $productNames[$i] . " " . $quantities[$i] . " " . $productPrices[$i];
        }

        return view('pages.quotation.show', compact('quotation', 'resultArr'));
    }

    public function destroy($id)
    {
        $quotation = Quotation::findOrFail($id);
    	$quotation->delete();

    	 $notification = array(
			'message' => 'Quotation deleted Successfully !!',
			'alert-type' => 'info'
		);

		return redirect()->back()->with($notification);
    }

    public function viewPDF($quotationId)
    {
        $quotation = Quotation::with('customer')->findOrFail($quotationId);

        $productNames = array();
        $productPrices = array();
        $resultArr = array();

        $productIds = explode("|", $quotation->product_id_arr);
        foreach($productIds as $key => $pId) {
            $product = Product::where('id', $pId)->first();
            $productName = $product->name;
            $productPrice = $product->sale_price;
            array_push($productNames, $productName);
            array_push($productPrices, $productPrice);
        }

        $quantities = explode("|", $quotation->quantity_arr);

        for ($i = 0; $i < count($productIds); $i++) {
            $resultArr[$i] = $productNames[$i] . " " . $quantities[$i] . " " . $productPrices[$i];
        }

        $pdf = PDF::loadView('pages.quotation.view_pdf', array('quotation'=>$quotation, 'resultArr'=>$resultArr));
        return $pdf->stream();
    }

    public function downloadPDF($quotationId)
    {
        $quotation = Quotation::with('customer')->findOrFail($quotationId);

        $productNames = array();
        $productPrices = array();
        $resultArr = array();

        $productIds = explode("|", $quotation->product_id_arr);
        foreach($productIds as $key => $pId) {
            $product = Product::where('id', $pId)->first();
            $productName = $product->name;
            $productPrice = $product->sale_price;
            array_push($productNames, $productName);
            array_push($productPrices, $productPrice);
        }

        $quantities = explode("|", $quotation->quantity_arr);

        for ($i = 0; $i < count($productIds); $i++) {
            $resultArr[$i] = $productNames[$i] . " " . $quantities[$i] . " " . $productPrices[$i];
        }

        $pdf = PDF::loadView('pages.quotation.download_pdf', array('quotation'=>$quotation, 'resultArr'=>$resultArr));
        return $pdf->download($quotation->quotation_ref_no . '_' . $quotation->customer->name . '.pdf');
    }
}
