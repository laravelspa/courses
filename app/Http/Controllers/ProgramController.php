<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{

    public function index(Request $req)
    {
        $course = Course::find($req->courseId);

        $programs = $course->programs;

        $data = ["programs" => $programs, "course" => $course];

        return view("programs.index", $data);
    }


    public function store(Request $req)
    {
        $req["courseId"] = $req->route("courseId");

        $req->validate([
            'name' => 'required|string|max:255',
            'courseId' => 'required|numeric|min:1|exists:courses,id'
        ]);

        Program::create([
            'name' => $req->name,
            "course_id" => $req->courseId
        ]);

        return redirect()->route('programs.index', $req->courseId)->with('successMsg', 'تم إنشاء البرنامج بنجاح');
    }


    public function update(Request $req, Program $program)
    {
        $req["courseId"] = $req->route("courseId");

        $req->validate([
            'name' => 'required|string|max:255',
            'courseId' => 'required|numeric|min:1|exists:courses,id'
        ]);

        $program = Program::find($req->programId);

        if (!$program) return redirect()->route('programs.index', $req->courseId)->with('errorMsg', 'البرنامج غير موجود !');

        $program->name = $req->name;

        $program->save();

        return redirect()->route('programs.index', $req->courseId)->with('successMsg', 'تم تعديل البرنامج بنجاح');
    }


    public function destroy(Request $req)
    {
        $program = Program::find($req->programId);

        if (!$program) return redirect()->route('programs.index', $req->courseId)->with('errorMsg', 'البرنامج غير موجود !');

        $program->delete();

        return redirect()->route('programs.index', $req->courseId)->with('successMsg', 'تم حذف البرنامج بنجاح');
    }
}