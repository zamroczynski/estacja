<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function uploadTrix(Request $request)
    {
        if ($request->hasFile('file')) {
            try {
                $filenamewithextension = $request->file('file')->getClientOriginalName();
                $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
                $extension = $request->file('file')->getClientOriginalExtension();
                $filenametostore = $filename . '_' . time() . '.' . $extension;
                $request->file('file')->storeAs('public/uploads', $filenametostore);
                $path = asset('storage/uploads/' . $filenametostore);
                echo $path;
            } catch (\Throwable $th) {
                echo $th->getMessage();
            }
            exit;
        }
    }
}
