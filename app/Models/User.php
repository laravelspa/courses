<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles, SoftDeletes, HasFactory, Notifiable;

    const ADMIN             = 1;
    const TEACHER           = 0;

    const R_OWNER           = "owner";
    const R_ADMIN           = "admin";
    const R_TEACHER         = "teacher";
    const R_GUEST           = "guest"; // default

    const P_VIEW_PROGRAM     = "view program";
    const P_ADD_PROGRAM      = "add program";
    const P_EDIT_PROGRAM     = "edit program";
    const P_DELETE_PROGRAM   = "delete program";

    const P_VIEW_COURSE     = "view course";
    const P_ADD_COURSE      = "add course";
    const P_EDIT_COURSE     = "edit course";
    const P_DELETE_COURSE   = "delete course";

    const P_VIEW_TABLE      = "view table";
    const P_ADD_TABLE       = "add table";
    const P_EDIT_TABLE      = "edit table";
    const P_DELETE_TABLE    = "delete table";

    const P_VIEW_USER       = "view user";
    const P_ADD_USER        = "add user";
    const P_EDIT_USER       = "edit user";
    const P_DELETE_USER     = "delete user";

    const P_VIEW_SETTING    = "view setting";
    const P_ADD_SETTING     = "add setting";
    const P_EDIT_SETTING    = "edit setting";
    const P_DELETE_SETTING  = "delete setting";

    const P_VIEW_EVENT    = "view event";
    const P_ADD_EVENT     = "add event";
    const P_EDIT_EVENT    = "edit event";
    const P_DELETE_EVENT  = "delete event";

    const P_VIEW_STUDENT    = "view student";
    const P_ADD_STUDENT     = "add student";
    const P_EDIT_STUDENT    = "edit student";
    const P_DELETE_STUDENT  = "delete student";

    const P_DEFAULT_OWNER = [
        self::P_VIEW_PROGRAM,
        self::P_ADD_PROGRAM,
        self::P_EDIT_PROGRAM,
        self::P_DELETE_PROGRAM,

        self::P_VIEW_COURSE,
        self::P_ADD_COURSE,
        self::P_EDIT_COURSE,
        self::P_DELETE_COURSE,

        self::P_VIEW_TABLE,
        self::P_ADD_TABLE,
        self::P_EDIT_TABLE,
        self::P_DELETE_TABLE,

        self::P_VIEW_USER,
        self::P_ADD_USER,
        self::P_EDIT_USER,
        self::P_DELETE_USER,

        self::P_VIEW_SETTING,
        self::P_ADD_SETTING,
        self::P_EDIT_SETTING,
        self::P_DELETE_SETTING,

        self::P_VIEW_EVENT,
        self::P_ADD_EVENT,
        self::P_EDIT_EVENT,
        self::P_DELETE_EVENT,

        self::P_VIEW_STUDENT,
        self::P_ADD_STUDENT,
        self::P_EDIT_STUDENT,
        self::P_DELETE_STUDENT,
    ];

    const P_DEFAULT_ADMIN = [
        self::P_VIEW_PROGRAM,
        self::P_ADD_PROGRAM,
        self::P_EDIT_PROGRAM,

        self::P_VIEW_COURSE,
        self::P_ADD_COURSE,
        self::P_EDIT_COURSE,

        self::P_VIEW_TABLE,
        self::P_ADD_TABLE,
        self::P_EDIT_TABLE,

        self::P_VIEW_STUDENT,
        self::P_ADD_STUDENT,
        self::P_EDIT_STUDENT
    ];

    const P_DEFAULT_TEACHER = [
        self::P_VIEW_COURSE,
        self::P_VIEW_TABLE,
        self::P_VIEW_PROGRAM,
        self::P_VIEW_EVENT,
        self::P_VIEW_STUDENT,
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'military_unit',
        'military_rank',
        "img",
        'name',
        'phone',
        'active',
        // 'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}