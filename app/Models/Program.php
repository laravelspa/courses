<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use App\Models\Table;

class Program extends Model
{
    use HasRoles, SoftDeletes, HasFactory, Notifiable;
    protected $fillable = ['name', 'course_id'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function tables()
    {
        return $this->hasMany(Table::class);
    }
}