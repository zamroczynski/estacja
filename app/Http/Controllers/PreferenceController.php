<?php

namespace App\Http\Controllers;

use App\Models\Preference;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreferenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $preferences = Preference::where('user_id', '=', Auth::id())->orderBy('created_at', 'desc')->get();
        $shifts = Shift::all();
        return view('schedule.userPreferences', [
            'preferences' => $preferences,
            'shifts' => $shifts
        ]);
    }
    public function indexAdmin()
    {
        $preferences = Preference::orderBy('date', 'desc')->get();
        return view('schedule.adminPreferences', [
            'preferences' => $preferences
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
        $checkPreference = Preference::where([
            ['user_id', '=', Auth::id()],
            ['date', '=', $request->dateP],
            ['shift_id', '=', $request->shift],
        ])->first();
        if ($checkPreference == null) {
            $preference = new Preference();
            $preference->user_id = Auth::id();
            $preference->date = $request->dateP;
            $preference->available = $request->available;
            $preference->shift_id = $request->shift;
            $preference->description = $request->description;
            $preference->save();
            return redirect()->route('userPreferences')->with('status', 'Preferencja dodana!');
        } else {
            return redirect()->route('userPreferences')->with('error', 'Istnieje już taka preferencja!');
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
        $preference = Preference::find($id);
        $preference->delete();
        return redirect()->route('userPreferences')->with('status', 'Preferencja usunięta!');
    }
}
