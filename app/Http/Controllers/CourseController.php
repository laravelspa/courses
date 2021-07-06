<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    // public function index()
    // {
    // $today = date('Y-m-d');
    // $courses = Course::where('date_to', '>=', $today)->get();
    // return view('courses.index')->withCourses($courses);
    //     $courses = Course::all();

    //     return view('courses.index')->withCourses($courses);
    // }

    public function index()
    {
        $courses = Course::all();

        return view('courses.index', ["courses" => $courses]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'uid'           => 'required|string|max:255|unique:courses,uid',
            'course_number' => 'required|string|max:255',
            'name'          => 'required|string|max:255',
            'date_from'     => 'required|string',
            'date_to'       => 'required|string',
        ]);

        Course::create([
            'uid'           => $request->uid,
            'course_number' => $request->course_number,
            'name'          => $request->name,
            'date_from'     => date('Y-m-d', strtotime($request->date_from)),
            'date_to'       => date('Y-m-d', strtotime($request->date_to)),
            'uid'           => $request->uid,
        ]);

        return redirect()->route('courses.index')->with('successMsg', 'تم إنشاء الدورة بنجاح');
    }

    // public function edit(Course $course)
    // {
    //     return view('courses.edit')->withCourse($course);
    // }


    public function update(Request $req)
    {
        $course = Course::find($req->id);
           
        $req->validate([
            'uid'           => 'required|string|max:255|unique:courses,uid,'.$req->id,
            'course_number' => 'required|string|max:255',
            'name'          => 'required|string|max:255',
            'date_from'     => 'required|string',
            'date_to'       => 'required|string',
        ]);

        if (!$course) return redirect()->route('courses.index')->with('errorMsg', 'الدورة غير موجودة !');
        
        $course->uid            = $req->uid;
        $course->course_number  = $req->course_number;
        $course->name           = $req->name;
        $course->date_from      = date('Y-m-d', strtotime($req->date_from));
        $course->date_to        = date('Y-m-d', strtotime($req->date_to));

        $course->update();

        return redirect()->route('courses.index')->with('successMsg', 'تم تعديل الدورة بنجاح');
    }


    public function destroy(Request $request)
    {
        Course::find($request->courseId)->delete();
        return redirect()->route('courses.index')->with('successMsg', 'تم حذف الدورة بنجاح');
    }
    /** 
     * Archeive Courses
     */
    // public function archived()
    // {
    //     $today = date('Y-m-d');
    //     $courses = Course::where('date_to', '<', $today)->get();
    //     return view('courses.archived')->withCourses($courses);
    // }
}