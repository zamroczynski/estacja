<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    private function checkNewTask(Request $request)
    {
        $this->validate(
            $request,
            [
                'title' => ['required', 'max:255'],
                'user' => ['required', 'integer', 'gte:1'],
                'deadline' => ['required', 'date']
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
            $this->checkNewTask($request);
            Task::create([
                'title' => $request->title,
                'description' => $request->content,
                'deadline' => $request->deadline,
                'done' => FALSE,
                'user_id' => $request->user,
                'admin_id' => Auth()->user()->id
            ]);
            return redirect()->route('adminTaskCreate')->with('status', 'Dodano nowe zadanie!');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['Wystąpił błąd!']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        try {
            $task = Task::find($id);
            return view('tasks.admin', ['tasks' => $task]);
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['Wystąpił błąd!']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //
    }
}
