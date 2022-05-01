<?php

namespace App\Http\Controllers;

use App\Enums\ModuleName;
use App\Models\Planogram;
use App\Models\PlanogramFile;
use App\Models\User;
use App\Notifications\DbNotification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
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
    public function adminList()
    {
        try {
            $planograms = Planogram::orderBy('created_at', 'desc')->get();
            $users = User::orderBy('created_at', 'desc')->get();
            return view('planogram.admin', [
                'planograms' => $planograms,
                'users' => $users
            ]);
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['Wystąpił błąd!']);
        }
    }

    public function add(Request $request)
    {
        try {
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
            return redirect()->route('adminPlanogram')->with('status', 'Dodano nowy planogram!');
        } catch (\Throwable $th) {
            return redirect()->route('adminPlanogram')->withErrors('Wystąpił błąd podczas dodawania planogramu');
        }
    }

    public function edit(int $id)
    {
        try {
            $planogram = Planogram::find($id);
            $users = User::orderBy('created_at', 'desc')->get();
            $files = PlanogramFile::where('planogram_id', '=', $id)->get();
            return view('planogram.edit', [
                'planogram' => $planogram,
                'users' => $users,
                'files' => $files
            ]);
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['Wystąpił błąd!']);
        }
    }

    public function deleteFile(int $id)
    {
        try {
            $planogramFile = PlanogramFile::find($id);
            Storage::delete($planogramFile->path);
            $planogramFile->delete();
            return 'Pilk został usunięty!';
        } catch (\Throwable $th) {
            return 'Nastąpił błąd: ' . $th->getMessage();
        }
    }

    public function update(Request $request)
    {
        try {
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
            return redirect()->route('adminPlanogram')->with('status', 'Edycja zakończona sukcesem!');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors([
                'error' => 'Wystąpił błąd podczas edycji: ' . $th->getMessage()
            ]);
        }
    }

    public function download(int $id)
    {
        try {
            $planogram = PlanogramFile::find($id);
            $pathInfo = pathinfo($planogram->path);
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
        } catch (\Throwable $th) {
            return response('Błąd pobierania! Spróbuj ponownie później lub skontaktuj się z administratorem.', 500);
        }
    }

    public function hide(int $id)
    {
        try {
            $planogram = Planogram::find($id);
            $planogram->current = 0;
            $planogram->save();
            return redirect()->back()->with('status', 'Planogram został ukryty!');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['Błąd serwera!']);
        }
    }

    public function publish(int $id)
    {
        try {
            $planogram = Planogram::find($id);
            $planogram->current = 1;
            $planogram->save();
            if ($planogram->user_id) {
                $message = 'Został do Ciebie przypisany nowy planogram o nazwie: ' . $planogram->name;
                Notification::send($planogram->user, new DbNotification($message, ModuleName::PLANOGRAMS));
            }
            return redirect()->back()->with('status', 'Planogram został opublikowany! Pracownik przypisany został powiadomiony!');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['Błąd serwera!']);
        }
    }

    public function index()
    {
        return view('planogram.userMenu');
    }

    public function my()
    {
        try {
            $planograms = Planogram::where([
                ['current', '=', 1],
                ['user_id', '=', Auth()->user()->id]
            ])
                ->orderBy('created_at', 'desc')
                ->get();
            return view('planogram.user', [
                'planograms' => $planograms
            ]);
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['Wystąpił błąd!']);
        }
    }

    public function list()
    {
        try {
            $planograms = Planogram::where('current', '=', 1)->orderBy('created_at', 'desc')->get();
            return view('planogram.user', [
                'planograms' => $planograms
            ]);
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['Wystąpił błąd!']);
        }
    }

    public function show($id)
    {
        try {
            $planogram = Planogram::find($id);
            $users = User::orderBy('created_at', 'desc')->get();
            $files = PlanogramFile::where('planogram_id', '=', $id)->get();
            return view('planogram.show', [
                'planogram' => $planogram,
                'files' => $files
            ]);
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['Wystąpił błąd!']);
        }
    }
}
