<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use App\Models\Program;

class Table extends Model
{
    use HasRoles, SoftDeletes, HasFactory, Notifiable;
    protected $fillable = ['week_number', 'pdf_src', 'date_from', 'date_to', 'program_id'];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}