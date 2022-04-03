<?php

namespace App\Http\Controllers;

use App\Enums\ModuleName;
use App\Models\Guide;
use App\Models\User;
use App\Notifications\DbNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class GuideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('guide.list', ['guides' => Guide::orderBy('created_at', 'desc')->get()]);
    }

    public function indexUser()
    {
        return view('guide.listUser', ['guides' => Guide::where('is_public', TRUE)->orderBy('created_at', 'desc')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('guide.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Guide::create([
            'text' => $request->content,
            'name' => $request->name
        ]);

        return redirect()->route('adminGuideList')->with('status', 'Instrukcja została zapisana!');
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $filenamewithextension = $request->file('file')->getClientOriginalName();
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            $extension = $request->file('file')->getClientOriginalExtension();
            $filenametostore = $filename . '_' . time() . '.' . $extension;
            $request->file('file')->storeAs('public/uploads', $filenametostore);
            $path = asset('storage/uploads/' . $filenametostore);
            echo $path;
            exit;
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
        return view('guide.show', ['guide' => Guide::find($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $guide = Guide::find($id);

        return view('guide.edit', ['guide' => $guide]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $guide = Guide::find($request->id);
        $guide->name = $request->name;
        $guide->text = $request->content;
        $guide->save();
        if ($guide->is_public) {
            $message = 'Instrukcja: "'.$guide->name.'" została zaktualizowana! Sprawdź ją w podręczniku stacji!';
            Notification::send(User::all(), new DbNotification($message, ModuleName::GUIDE));
        }
        return redirect()->route('adminGuideList')->with('status', 'Instrukcja została zapisana!');
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

    private function changeStatus($id, $status)
    {
        $guide = Guide::find($id);
        if ($status) {
            $guide->is_public = TRUE;
        } else {
            $guide->is_public = FALSE;
        }
        $guide->save();
    }

    public function public(Request $request)
    {
        //dd($request);
        $this->changeStatus($request->id, TRUE);
        Notification::send(User::all(), new DbNotification('Nowa instrukcja została opublikowana! Sprawdź ją w podręczniku stacji!', ModuleName::GUIDE));
        return redirect()->route('adminGuideList')->with('status', 'Instrukcja została opublikowana!');
    }

    public function unPublic(Request $request)
    {
        $this->changeStatus($request->id, FALSE);
        return redirect()->route('adminGuideList')->with('status', 'Instrukcja jest prywatna!');
    }
}
