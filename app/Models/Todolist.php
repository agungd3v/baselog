<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todolist extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function group() {
        return $this->belongsTo(Group::class, 'group_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'assign_to', 'id');
    }
}
