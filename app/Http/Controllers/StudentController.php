<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function allStudents(Request $request)
    {
        $columns = array( 
            0 =>'military_num',
            1 =>'name',
            2 => 'section',
            3 => 'id',
            4 => 'id'
        );
  
        $totalData = Student::count();
        
        $totalFiltered = $totalData; 
        // dd($request->all);
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $students = Student::offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();
        }
        else {
            $search = $request->input('search.value'); 

            $students =  Student::where('military_num','LIKE',"%{$search}%")
                            ->orWhere('name', 'LIKE',"%{$search}%")
                            ->orWhere('section', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = Student::where('military_num','LIKE',"%{$search}%")
                                    ->orWhere('name', 'LIKE',"%{$search}%")
                                    ->orWhere('section', 'LIKE',"%{$search}%")
                                    ->count();
        }

        $data = array();
        if(!empty($students))
        {
            foreach ($students as $student)
            {
                $nestedData['military_num'] = $student->military_num;
                $nestedData['name'] = $student->name;
                $nestedData['section'] = $student->section;
                $nestedData['course_name'] = $student->course->name;
                $nestedData['actions'] = '<a class="text-success ml-2" id="btnUpdateStudentModal" 
                data-toggle="modal" data-target="#updateStudentModal"
                data-studentId="'.$student->id.'"
                data-studentName="'.$student->name.'"
                data-military_num="'.$student->military_num.'"
                data-section="'.$student->section.'"
                data-courseId="'.$student->course->id.'">
                <i class="fa fa-edit fa-fw"></i>
            </a>
            <a href="" class="text-danger mx-2" id="btnDeleteStudentModal" data-toggle="modal"
                data-target="#deleteStudentModal" data-name="'.$student->name.'" data-id="'.$student->id.'" data-courseId="'.$student->course->id.'">
                <i class="fa fa-trash-alt fa-fw"></i>
            </a>';
                $data[] = $nestedData;
            }
        }
          
        $json_data = array(
            "draw"            => intval($request->input('draw')),  
            "recordsTotal"    => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered), 
            "data"            => $data   
        );
            
        echo json_encode($json_data);
    }

    public function studentsImport(Request $request)
    {
        $courseId = $request->course_id;
        $students = array_slice(json_decode($request->students),1);

        foreach ($students as $key => $student) {
            $name = $students[$key][0];
            $military_num = $students[$key][1];
            $section = $students[$key][2];

            Student::insert([
                'name' => $name,
                'military_num' => $military_num,
                'section' => $section,
                'course_id' => $courseId
            ]);
        }
        return response()->json(['status' => true, 'successMsg' => 'تم اضافه الطلاب بنجاح']);
    }
    public function all(Request $req)
    {
        $courses = Course::all();
        return view("students.all")->withCourses($courses);
    }

    public function index(Request $req)
    {
        $course = Course::find($req->courseId);

        $students = $course->students;

        $data = ["students" => $students, "course" => $course];

        return view("students.index", $data);
    }


    public function store(Request $req)
    {
        $req["courseId"] = $req->route("courseId");

        // dd($req->military_num);

        $req->validate([
            'name'          => 'required|string|max:255',
            "military_num"  => 'required|numeric|min:1',
            "section"       => 'required|string|max:255',
            'courseId'      => 'required|numeric|min:1|exists:courses,id'
        ]);

        Student::create([
            'name'          => $req->name,
            'military_num'  => $req->military_num,
            'section'       => $req->section,
            "course_id"     => $req->courseId
        ]);

        return redirect()->route('students.index', $req->courseId)->with('successMsg', 'تم اضافه الطالب بنجاح');
    }


    public function update(Request $req)
    {
        $req["courseId"] = $req->route("courseId");

        $req->validate([
            'name'          => 'required|string|max:255',
            "military_num"  => 'required|numeric|min:1',
            "section"       => 'required|string|max:255',
            'courseId'      => 'required|numeric|min:1|exists:courses,id'
        ]);

        $student = Student::find($req->studentId);

        if (!$student) return redirect()->route('students.index', $req->courseId)->with('errorMsg', 'الطالب غير موجود !');

        $student->name          = $req->name;
        $student->section       = $req->section;
        $student->military_num  = $req->military_num;

        $student->save();

        return redirect()->route('students.all', $req->courseId)->with('successMsg', 'تم اضافه الطالب بنجاح');
    }


    public function destroy(Request $req, Course $course)
    {
        $student = Student::find($req->studentId);

        if (!$student) return redirect()->route('students.all', $req->courseId)->with('errorMsg', 'الطالب غير موجود !');

        $student->delete();

        return redirect()->route('students.all', $req->courseId)->with('successMsg', 'تم حذف الطالب بنجاح');
    }
}