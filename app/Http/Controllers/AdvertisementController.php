<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdvertisementController extends Controller
{
    /**
     * Display a listing of the public resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexUser()
    {
        return view('advertisements.user', ['advertisements' => Advertisement::getUserAd()]);
    }

    /**
     * Display a listing of the all resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexAdmin()
    {
        return view('advertisements.admin', ['advertisements' => Advertisement::getAdminAd()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('advertisements.create');
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
     * @param  \App\Models\int  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        return view('advertisements.showUser', ['ad' => Advertisement::find($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\int  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function edit(int $advertisement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\int  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $advertisement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\int  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $advertisement)
    {
        //
    }
}
