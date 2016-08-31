<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\TaskRepository;

class TaskController extends Controller
{
  
  /**  1st edition
  * Create a new controller instance.
  *
  * @return void

  public function __construct()
  {
    $this->middleware('auth');
  }
  */
  
    /**
     * The task repository instance.
     *
     * @var TaskRepository
     */
    protected $tasks;

    /**
     * Create a new controller instance.
     *
     * @param  TaskRepository  $tasks
     * @return void
     */
    public function __construct(TaskRepository $tasks)
    {
        $this->middleware('auth');

        $this->tasks = $tasks;
    }

  
  /** 1st edition
  * Display a list of all of the user's task.
  *
  * @param  Request  $request
  * @return Response
  
  public function index(Request $request)
  {
    return view('tasks.index');
  }
  */
  
 /**  2nd edition 
  * Display a list of all of the user's task.
  *
  * @param  Request  $request
  * @return Response

  public function index(Request $request)
  {
      $tasks = $request->user()->tasks()->get();

      return view('tasks.index', [
          'tasks' => $tasks,
      ]);
  }
  */
  
      /**
     * Display a list of all of the user's task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        return view('tasks.index', [
            'tasks' => $this->tasks->forUser($request->user()),
        ]);
    }
  
    /**
     * Create a new task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:10',
        ]);

        $request->user()->tasks()->create([
            'name' => $request->name,
        ]);

        return redirect('/tasks');
    }
    
     /**
     * Destroy the given task.
     *
     * @param  Request  $request
     * @param  Task  $task
     * @return Response
     */
    public function destroy(Request $request, Task $task){
        //
        $this->authorize('destroy', $task);
        
        $task->delete();

        return redirect('/tasks');

    }   
}
