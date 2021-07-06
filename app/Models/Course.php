<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use App\Models\Program;
use App\Models\Student;

class Course extends Model
{
    use HasRoles, SoftDeletes, HasFactory, Notifiable;

    protected $fillable = ['uid', 'course_number', 'name', 'date_from', 'date_to'];

    public function programs()
    {
        return $this->hasMany(Program::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function students_count()
    {
        return $this->hasMany(Student::class)->count();
    }
}