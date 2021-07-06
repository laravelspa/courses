<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use App\Models\Course;

class Student extends Model
{
    use HasRoles, SoftDeletes, HasFactory, Notifiable;

    protected $fillable = ['name', 'course_id', "military_num", "section"];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }


    public function course_name()
    {
        $course = Course::where('id', $this->course_id)->get("name")->first();

        return $course->name;
    }
}