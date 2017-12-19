<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Price;
use App\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;

class PricesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request, $product_id)
    {
        $product = Product::findOrFail($product_id);
        session(['product_id' => $product_id]);
        session(['product_price' => $product->price]);

        $start_date = (!empty($request->start_date))? $request->start_date : date('Y',strtotime('-1 year')).'-01-01';
        $end_date = (!empty($request->end_date))? $request->end_date : date('Y').'-12-31';


        $prices = Price::where('product_id','=', $product_id)
                        ->where(function ($query) use ($start_date, $end_date) {
                            $query->where('start_date','>=',$start_date)
                                ->orWhere('end_date','<=',$end_date);
                        })
                        ->get();



        $chart_data = Price::GetChartData($prices, $start_date, $end_date);

        return view('backEnd.admin.prices.index', compact('prices','product','chart_data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $product_id = session('product_id');
        return view('backEnd.admin.prices.create', compact('product_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['product_id' => 'required', 'price' => 'required', 'start_date' => 'required', 'end_date' => 'required', ]);

        Price::create($request->all());

        Session::flash('message', 'Price added!');
        Session::flash('status', 'success');

        return redirect('admin/prices/index/'.session('product_id'));
    }

    public function edit($id)
    {
        $price = Price::findOrFail($id);

        return view('backEnd.admin.prices.edit', compact('price'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $this->validate($request, ['product_id' => 'required', 'price' => 'required', 'start_date' => 'required', 'end_date' => 'required', ]);

        $price = Price::findOrFail($id);
        $price->update($request->all());

        Session::flash('message', 'Price updated!');
        Session::flash('status', 'success');

        return redirect('admin/prices/index/'.session('product_id'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $price = Price::findOrFail($id);

        $price->delete();

        Session::flash('message', 'Price deleted!');
        Session::flash('status', 'success');

        return redirect('admin/prices/index/'.session('product_id'));
    }

}
