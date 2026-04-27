<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
    'student_id',
    'first_name',
    'last_name',
    'age',
    'course',
    'gender'
];
// Links the student to their user account via their ID
public function account()
{
    return $this->belongsTo(User::class, 'student_id', 'username');
}
}
