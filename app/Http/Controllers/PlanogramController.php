<?php

namespace App\Http\Controllers;

use App\Models\Planogram;
use App\Models\PlanogramFile;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PlanogramController extends Controller
{
    private function checkForm(Request $request, $update = FALSE)
    {
        if ($update)
            $planogram = ['mimes:pdf,jpg,jpeg,png', 'max:65536'];
        else
            $planogram = ['required', 'mimes:pdf,jpg,jpeg,png', 'max:65536'];
        $this->validate(
            $request,
            [
                'name' => ['required', 'max:255'],
                'date' => ['required', 'date'],
                'planogram.*' => $planogram
            ],
            [
                'name.required' => 'Planogram musi mieć nazwe!',
                'name.max' => 'Nazwa planogramu nie może mieć więcej niż 255 znaków!',
                'date.required' => 'Planogram musi mieć date początku obowiązywania!',
                'date.date' => 'Błędna data!',
                'planogram.required' => 'Planogram musi mieć plik!',
                'planogram.file' => 'Błąd pliku!',
                'planogram.mimes' => 'Błędny format pliku!',
                'planogram.size' => 'Plik jest za duży!',
            ]
        );
    }
    public function list()
    {
        $planograms = Planogram::orderBy('created_at', 'desc')->get();
        $users = User::orderBy('created_at', 'desc')->get();
        return view('planogram.admin', [
            'planograms' => $planograms,
            'users' => $users
        ]);
    }

    public function add(Request $request)
    {
        $this->checkForm($request);
        $planogram = new Planogram();
        $planogram->name = $request->name;
        $planogram->date_start = $request->date;
        if ($request->user > 0) {
            $planogram->user_id = $request->user;
        }
        $planogram->save();
        foreach ($request->file('planogram') as $file) {
            $planogramFile = new PlanogramFile();
            $planogramFile->name = $file->getClientOriginalName();
            $planogramFile->path = $file->store('planogram');
            $planogramFile->planogram_id = $planogram->id;
            $planogramFile->save();
        }
        return redirect()->route('adminPlanogram');
    }

    public function edit(int $id)
    {
        $planogram = Planogram::find($id);
        $users = User::orderBy('created_at', 'desc')->get();
        $files = PlanogramFile::where('planogram_id', '=', $id)->get();
        return view('planogram.edit', [
            'planogram' => $planogram,
            'users' => $users,
            'files' => $files
        ]);
    }

    public function deleteFile(int $id)
    {
        try {
            $planogramFile = PlanogramFile::find($id);
            $planogramFile->delete();
            return 'Pilk został usunięty!';
        } catch (\Throwable $th) {
            return 'Nastąpił błąd: ' . $th->getMessage();
        }

    }

    public function update(Request $request)
    {
        $this->checkForm($request, TRUE);
        $planogram = Planogram::find($request->id);
        $planogram->name = $request->name;
        $planogram->date_start = $request->date;
        if ($request->user > 0) {
            $planogram->user_id = $request->user;
        }
        $planogram->save();
        if ($request->has('planogram')) {
            foreach ($request->file('planogram') as $file) {
                $planogramFile = new PlanogramFile();
                $planogramFile->name = $file->getClientOriginalName();
                $planogramFile->path = $file->store('planogram');
                $planogramFile->planogram_id = $planogram->id;
                $planogramFile->save();
            }
        }
        return redirect()->route('adminPlanogram');
    }

    public function download(int $id)
    {
        $planogram = PlanogramFile::find($id);
        $pathInfo = pathinfo($planogram->path);
        $contentType = '';
        switch ($pathInfo['extension']) {
            case 'pdf':
                $contentType = 'application/pdf';
                break;

            case 'png':
                $contentType = 'image/png';
                break;

            case 'jpeg':
                $contentType = 'image/jpeg';
                break;

            case 'jpg':
                $contentType = 'image/jpg';
                break;

            default:
                throw new Exception("Bad file extension!", 1);
                break;
        }
        if ($pathInfo['extension'])
            return response()->file($planogram->path, [
                'Content-Type' => $contentType,
                'Content-Disposition' => 'inline; filename="' . $planogram->name . '"'
            ]);
    }

    public function hide(int $id)
    {
        //do zrobienia
    }

    public function publish(int $id)
    {
        //do zrobienia
    }
}
