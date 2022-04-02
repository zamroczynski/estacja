<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('schedule.shift', [
            'shifts' => Shift::all()
        ]);
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
        $shift = new Shift();
        $shift->name = $request->name;
        $shift->start = $request->start;
        $shift->stop = $request->stop;
        $shift->duration = $request->duration;
        $shift->number_of_employees = $request->numberOfEmployees;
        $shift->save();
        return redirect()->route('shiftList')->with('status', 'Zmiana dodana!');
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
        return view('schedule.editShift', [
            'shift' => Shift::find($id)
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
        $shift = Shift::find($id);
        $shift->name = $request->name;
        $shift->start = $request->start;
        $shift->stop = $request->stop;
        $shift->duration = $request->duration;
        $shift->number_of_employees = $request->numberOfEmployees;
        $shift->save();
        return redirect()->route('shiftList')->with('status', 'Sukces!');
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
