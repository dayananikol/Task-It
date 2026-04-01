<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Inertia\Inertia;

class TaskController extends Controller
{
    // GET
    public function index(Request $request)
    {
        // 1. Get all tasks from database
        // $tasks is the variable that'll store the value, Task is the model that represents the tasks table in the database, and all() is a method that retrieves all records from that table
        //$request->user() is basically “give me the logged-in user”
        // we call tasks() from user model, which gives us a query builder for the tasks associated with that user
        // then we order them by creation date (newest first) and get the results
        $tasks = $request->user()->tasks()->orderBy('created_at', 'desc')->get(); // dont forget to import Task model
        
    
        // 2. Return tasks to frontend (or JSON for API)
        // i will need vue page for this
        return Inertia::render('Tasks/Index', ['tasks' => $tasks]);
    }   

    // POST
    public function store(Request $request)
    {
        // 1. create and save new task
            Task::create([
                'title' => $request->title,
                'description' => $request->description,
                'user_id' => $request->user()->id, // associate task with logged-in user
            ]);
    
            // 2. Return success or new task
            return redirect()->back()->with('success', 'Task created successfully!');
        
        
    }
    // PUT
    public function update(Request $request, $id)
    {
        // 1. Find task by $id
        $task = Task::find($id);

        // 2. Update fields (title, description)
        $task->title = $request->title;
        //$task->title → refers to the title column of this particular row (the task) in the tasks table.
        //$request->title → is what the user sent, the new value you want to save.

        $task->description = $request->description;

        $task->user_id = $request->user()->id; //basically who is logged in? → get their id → store that id inside the task
    

        // 3. Save and return updated task
        $task->save();
        return redirect()->back()->with('success', 'Task updated successfully!');
    }

    // DELETE
    public function destroy(Request $request, $id)
    {
        // 1. Find task by $id
        $task = $request->user()->tasks()->find($id); 
        // $request->user() → fetches the currently logged-in user
        //->tasks() → calls the relationship method defined in the User model
        // ->find($id) → searches within the user’s tasks for the one with that specific. $id comes from the frontend (like when we click Delete), passed via the route parameter to the destroy method.

        // 2. Delete it from database
        $task->delete();

        // 3. Return success message
        return redirect()->back()->with('success', 'Task deleted successfully!');
    }

}
