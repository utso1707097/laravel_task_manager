<?php

use App\Http\Requests\TaskRequest;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Task;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// class Task
// {
//   public function __construct(
//     public int $id,
//     public string $title,
//     public string $description,
//     public ?string $long_description,
//     public bool $completed,
//     public string $created_at,
//     public string $updated_at
//   ) {
//   }
// }

// $tasks = [
//   new Task(
//     1,
//     'Buy groceries',
//     'Task 1 description',
//     'Task 1 long description',
//     false,
//     '2023-03-01 12:00:00',
//     '2023-03-01 12:00:00'
//   ),
//   new Task(
//     2,
//     'Sell old stuff',
//     'Task 2 description',
//     null,
//     false,
//     '2023-03-02 12:00:00',
//     '2023-03-02 12:00:00'
//   ),
//   new Task(
//     3,
//     'Learn programming',
//     'Task 3 description',
//     'Task 3 long description',
//     true,
//     '2023-03-03 12:00:00',
//     '2023-03-03 12:00:00'
//   ),
//   new Task(
//     4,
//     'Take dogs for a walk',
//     'Task 4 description',
//     null,
//     false,
//     '2023-03-04 12:00:00',
//     '2023-03-04 12:00:00'
//   ),
// ];

Route::get('/',function(){
    return redirect()->route('tasks.index');
});




// Route::get('/tasks', function () use($tasks){
//     return view('index',[/*'name' => 'utso',*/ 'script'=>'<script>index.php</script>','tasks'=>$tasks]);
// }) -> name('tasks.index'); 

Route::get('/tasks',function(){
    return view('index',[
        //'tasks'=> \App\Models\Task::all()
        'tasks'=> Task::latest()->paginate(10)
        // 'tasks'=> \App\Models\Task::latest()->get() //show the latest task first
        // 'tasks'=> \App\Models\Task::latest()->where('completed',true)->get() //only shows the completed tasks
    ]);
}) ->name('tasks.index');

Route::post('/tasks',function(TaskRequest $request){
    //dd($request->all());
    // $data = $request->validated();
    // $task = new Task;
    // $task -> title = $data['title'];
    // $task -> description = $data['description'];
    // $task -> long_description = $data['long_description'];
    // $task -> save();
    $task = Task::create($request->validated());

    return redirect() -> route('tasks.show',['task' => $task->id ])
        ->with('success', 'Task created successfully!');
})->name('tasks.store');

Route::put('/tasks/{task}',function(Task $task, TaskRequest $request){
    //dd($request->all());
    // $data = $request->validated();
    // $task -> title = $data['title'];
    // $task -> description = $data['description'];
    // $task -> long_description = $data['long_description'];
    // $task -> save();
    $task->update($request->validated());

    return redirect() -> route('tasks.show',['task' => $task->id ])
        ->with('success', 'Task updated successfully!');
})->name('tasks.update');


Route::view('/tasks/create','create') -> name ('tasks.create');


Route::get('/tasks/{task}/edit',function(Task $task){
    // return 'One single task';
    return view('edit',[
        'task' => $task
    ]);
    
}) -> name('tasks.edit');

Route::get('/tasks/{task}',function(Task $task){
    // return 'One single task';
    return view('show',['task' => $task ]);
    
}) -> name('tasks.show');

Route::delete('tasks/{task}',function(Task $task){
    $task -> delete();
    return redirect()->route('tasks.index')
        ->with('success','Task deleted successfully!');
}) -> name('tasks.destroy');

Route::put('/tasks/{task}/toggle_complete',function(Task $task){
    $task -> toggleComplete();
    return redirect()->back()->with('success','Task updated successfully!');
})->name('tasks.toggle-complete');


// Route::get('/tasks/{id}',function($id) use ($tasks){
//     // return 'One single task';
//     $task = collect($tasks) ->firstWhere('id', $id);  //arrays to laravel collection object -> in php arrays are not object
//     if(!$task){
//         abort(Response::HTTP_NOT_FOUND);
//     }

//     return view('show',['task' => $task]);
// }) -> name('tasks.show');





// Route::get('/welcome',function(){
//     return view('welcome'); 
// })->name('named_route'); //providing a route name

// //dynamic routes
// Route::get('/great/{name}',function($name){
//     // return 'Hello '.$name .'!';
//     echo "Hello {$name}";
// });


// Route::get('/redirectToHello',function(){
//     return redirect('/welcome');
// });

// Route::get('/redirect-welcome',function(){
//     return redirect()->route('named_route');
// });

Route::fallback(function(){
    return "Route don't matches but still utso's route gonna find it";
});