<?php
//タスク

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
//use Log;
use App\Task;

//
class TasksController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }
    /**************************************
     *
     **************************************/
    public function index()
    {
        $tasks = [];
        return view('tasks/index')->with('tasks', $tasks);
    }    
    /**************************************
     *
     **************************************/
    public function create()
    {
        return view('tasks/create')->with('task', new Task());
    }   
   /**************************************
     *
     **************************************/    
    public function store(Request $request)
    {
        $inputs = $request->all();
//        print_r ($inputs["title"]);
        $key_head  = "task:";
        $reply= Redis::command('INCR', ["idx-task"]);
        $key = $key_head . $reply;
        Redis::command('ZADD', ["sorted_tasks", $reply, $key]);
        $item = [
            "id"=> $key, "title"=>request('title'), "content"=> request('content')
        ] ;
        $json = json_encode($item);
        Redis::set($key , $json);
//        var_dump( $key );        
        return redirect()->route('tasks.index');
    }    
    /**************************************
     *
     **************************************/
    public function show($id)
    {
        return view('tasks/show')->with('task_id', $id );
    }   
    /**************************************
     *
     **************************************/
    public function edit($id)
    {
        $task = Redis::get( $id );
        $task = json_decode ( $task , true);
//var_dump( $task );
        return view('tasks/edit')->with('task', $task);
    }
    /**************************************
     *
     **************************************/
    public function update(Request $request, $id)
    {
        $key = $id;
        $item = [
            "id"=> $key, "title"=>request('title'), "content"=> request('content')
        ] ;     
        $json = json_encode($item);
        Redis::set($key , $json);         
        return redirect()->route('tasks.index');
    }
    /**************************************
     *
     **************************************/
    public function destroy($id)
    {
        Redis::command('zrem', ["sorted_tasks", $id ]);
        Redis::command('del', [ $id ]);
        return redirect()->route('tasks.index');
    }      

    /**************************************
     *
     **************************************/
    public function test1(){
        /*
        $reply = Redis::command('zrevrange', ["sorted_tasks", 0, 19]);
        $reply_tasks = Redis::command('mget', [$reply]);
        $tasks_items = [];
        foreach($reply_tasks as $reply_task ){
            $row = json_decode ( $reply_task , true);
            $tasks_items[] = $row;
        }
        print_r( $tasks_items );
        $key_head  = "task:";
        $reply= Redis::command('INCR', ["idx-task"]);
        $key = $key_head . $reply;
        Redis::command('ZADD', ["sorted_tasks", $reply, $key]);
        $item = ["id"=> 0, "title"=>"t1", "content"=> "c1"] ;
        $json = json_encode($item);
        print_r($reply);
        print_r($json);
        Redis::set($key , $json);
        */
        Redis::set('foo', 'Taylor');
        $s = Redis::get('foo');
        var_dump( $s );
        exit();
    }


}
