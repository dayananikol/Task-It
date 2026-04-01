<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title', 'description', 'user_id']; // allow user_id so we can associate tasks with users

    public function user() //relationship method to link tasks to users, this means each task belongs to a user, and we can access the user of a task using $task->user
    {
        return $this->belongsTo(User::class);
    }
}


