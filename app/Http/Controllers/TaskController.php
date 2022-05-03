<?php

namespace App\Http\Controllers;

use App\Enums\ModuleName;
use App\Models\Task;
use App\Models\User;
use App\Notifications\DbNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Redirect;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $tasks = Task::orderBy('created_at', 'desc')->get();
            return view('tasks.admin', ['tasks' => $tasks]);
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['Wystąpił błąd!']);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $users = User::orderBy('created_at', 'desc')->get();
            return view('tasks.create', ['users' => $users]);
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['Wystąpił błąd!']);
        }
    }

    private function checkRequest(Request $request, int $update = 0)
    {
        if ($update) {
            $done = ['required', 'integer'];
        } else {
            $done = ['nullable'];
        }
        $this->validate(
            $request,
            [
                'title' => ['required', 'max:255'],
                'user' => ['required', 'integer', 'gte:1'],
                'deadline' => ['required', 'date'],
                'done' => $done,
                'comment' => ['nullable', 'string']
            ],
            [
                'title.required' => 'Zadanie musi mieć nazwę!',
                'title.max' => 'Maksymalna długość nazwy to 255 znaków!',
                'user.*' => 'Pranownik musi być przypisany do zadania!',
                'deadline.*' => 'Błędna data!'
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $this->checkRequest($request);
            $task = Task::create([
                'title' => $request->title,
                'description' => $request->content,
                'deadline' => $request->deadline,
                'done' => FALSE,
                'user_id' => $request->user,
                'admin_id' => Auth()->user()->id,
                'last_id' => Auth()->user()->id
            ]);
            $message = 'Zostało do Ciebie przypisane nowe zadanie o nazwie: "'.$task->title.'"';
            Notification::send($task->user, new DbNotification($message, ModuleName::TASKS));
            return redirect()->route('adminTaskCreate')->with('status', 'Dodano nowe zadanie!');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['Wystąpił błąd!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        try {
            $task = Task::find($id);
            return view('tasks.showAdmin', ['task' => $task]);
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['Wystąpił błąd!']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        try {
            $task = Task::find($id);
            $users = User::orderBy('created_at', 'desc')->get();
            return view('tasks.edit', [
                'task' => $task,
                'users' => $users
            ]);
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['Wystąpił błąd!']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        try {
            $this->checkRequest($request, 1);
            $task = Task::find($id);
            $task->title = $request->title;
            $task->description = $request->description;
            $task->deadline = $request->deadline;
            $task->done = $request->done;
            $task->user_id = $request->user;
            $task->admin_id = Auth()->user()->id;
            $task->last_id = Auth()->user()->id;
            $task->comment = $request->comment;
            $task->save();
            $message = 'Przypisane do Ciebie zadanie o nazwie: "'.$task->title.'" zostało zaaktualizowane.';
            Notification::send($task->user, new DbNotification($message, ModuleName::TASKS));
            return redirect()->back()->with('status', 'Zadanie zostało zaktualizowane!');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['Wystąpił błąd!']);
        }
    }

    /**
     * Show the form for creating a new resource with completed fields.
     *
     * @param  int  $task
     * @return \Illuminate\Http\Response
     */
    public function copy(int $id)
    {
        // do zrobienia
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        //
    }
}
