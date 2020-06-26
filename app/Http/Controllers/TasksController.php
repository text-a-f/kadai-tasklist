<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use Illuminate\Support\Facades\Auth;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (\Auth::check()) {
            $data = [];
            $user = \Auth::user();  //ログインしているユーザー情報
            $tasks = $user->tasks()->orderBy('created_at')->paginate(10);
            $data = [
                'user' => $user,
                'tasks' => $tasks,
            ];

            return view('tasks.index', $data);
        } else {
            return view('welcome');
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (\Auth::check()) {
            $task = new Task;

            return view('tasks.create', [
                'tasks' => $task,]);
        } else {
            return redirect('/');
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (\Auth::check()) {
        //     $this->validate($request, [
        //         'status' => 'required|max:10',   // 追加
        // ]);

            $task = new Task;
            $task->status = $request->status;   // 追加
            $task->content = $request->content;
            $task->user_id = \Auth::id();
            $task->save();
        }
            return redirect('/');
   }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::find($id);
        if (\Auth::check() && \Auth::id() === $task->user_id) {

            return view('tasks.show', [
                'task' => $task,
        ]);
        } else {
            return redirect('/');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::find($id);
        if (\Auth::check() && \Auth::id() === $task->user_id) {
            $task->user_id = \Auth::id();

            return view('tasks.edit', [
                'task' => $task,]);
        }
            return redirect('/');
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
        $this->validate($request, [
            'status' => 'required|max:10',   // 追加,
        ]);
        $task = Task::find($id);
        if (\Auth::check() && \Auth::id() === $task->user_id) {
            $task->status = $request->status;
            $task->content = $request->content;
            $task->user_id = \Auth::id();
            $task->save();
        }
            return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        if (Auth::check() && \Auth::id() === $task->user_id) {
            $task->user_id = \Auth::id();
            $task->delete();
        }
            return redirect('/');
    }
}
