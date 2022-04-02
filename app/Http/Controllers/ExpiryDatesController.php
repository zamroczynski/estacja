<?php

namespace App\Http\Controllers;

use App\Models\ExpiryDate;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpiryDatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $date = Carbon::now()->format('Y-m-d');
        $oldDate = $date;
        if ($request->has('date')) {
            $date = $request->query('date');
            $oldDate = $request->query('date');
        }
        return view('eds.list', [
            'dates' => ExpiryDate::where('date', '=', $date)->get(),
            'oldDate' => $oldDate
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return view('eds.add', [
            'products' => Product::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $checkDate = ExpiryDate::where('date', '=', $request->dateInput)->where('product_id', '=', $request->product_id)->first();
        if ($checkDate == null){
            $expiryDate = new ExpiryDate();
            $expiryDate->date = $request->dateInput;
            $expiryDate->product_id = $request->product_id;
            $expiryDate->amount = $request->amount;
            $expiryDate->user_id = Auth()->user()->id;
            $expiryDate->save();
            return redirect()->route('edsAdd')->with('status', 'Termin dodany!');
        } else {
            return redirect()->route('edsAdd')->with('error', 'Wybrany termin istnieje!');
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('eds.show', [
            'dateE' => ExpiryDate::find($id),
            'products' => Product::all()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        if (Auth()->user()->role == 'admin') {
            $dates = ExpiryDate::orderBy('created_at', 'desc')->get();
        } else {
            $dates = ExpiryDate::where('user_id', '=', Auth()->user()->id)->orderBy('created_at', 'desc')->get();
        }
        return view('eds.edit', [
            'dates' => $dates
        ]);
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
        $checkDate = ExpiryDate::where('date', '=', $request->dateInput)->where('product_id', '=', $request->product_id)->first();
        if ($checkDate == null){
            $expiryDate = ExpiryDate::find($id);
            $expiryDate->date = $request->dateInput;
            $expiryDate->amount = $request->amount;
            $expiryDate->product_id = $request->product_id;
            $expiryDate->save();
            return redirect()->route('edsEdit')->with('status', 'Sukces!');
        } else {
            return redirect()->route('edsEdit')->with('error', 'Istnieje już taki termin!');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $expiryDate = ExpiryDate::find($id);
        $expiryDate->delete();
        return redirect()->route('edsEdit')->with('status', 'Sukces!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function report(Request $request)
    {
        $dates = ExpiryDate::whereBetween('date', [$request->dataStart, $request->dataEnd])->orderBy('date')->get();
        return view('eds.report', [
            'dates' => $dates,
            'dataStart' => $request->dataStart,
            'dataEnd' => $request->dataEnd
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeProduct(Request $request)
    {
        $checkProduct = Product::where('name', '=', $request->nameProduct)->first();
        if ($checkProduct == null){
            $product = new Product();
            $product->name = $request->nameProduct;
            $product->save();
            return redirect()->route('edsAdd')->with('status', 'Produkt dodany!');
        } else {
            return redirect()->route('edsAdd')->with('error', 'Istnieje już taki produkt!');
        }

    }
}
