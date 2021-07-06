<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Program;
use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{

    public function index(Request $req)
    {
        $program = Program::find($req->programId);

        // $course = Course::find($req->courseId);
        $course = $program->course;

        $tables = $program->tables;

        $data = ["tables" => $tables, "program" => $program, "course" => $course];

        return view("tables.index", $data);
    }


    public function store(Request $req) // Add $program Model Instance
    {
        // $program = Program::findOrFail($req->program); // This Not Correct

        $req["programId"] = $req->route("programId");

        $req->validate([
            'week_number'   => 'required|numeric|min:1',
            'pdf'           => 'required|mimes:pdf|max:10000',
            'date_from'     => 'required|string',
            'date_to'       => 'required|string',
            'programId'     => 'required|numeric|min:1|exists:programs,id'
        ]);

        $pdf = sha1(time()) . "." . $req->pdf->getClientOriginalExtension();

        $req->pdf->move(public_path('/pdf'), $pdf);

        Table::create([
            'week_number'   => $req->week_number,
            'pdf_src'       => $pdf,
            'date_from'     => date('Y-m-d', strtotime($req->date_from)),
            'date_to'       => date('Y-m-d', strtotime($req->date_to)),
            "program_id"    => $req->programId
        ]);

        return redirect()->route('tables.index', [$req->route("courseId"), $req->programId])->with('successMsg', 'تم اضافة الجدول بنجاح');
    }


    public function update(Request $req)
    {

        $req["programId"] = $req->route("programId");

        $req->validate([
            'week_number'   => 'required|numeric|min:1',
            'pdf'           => 'nullable|mimes:pdf|max:10000',
            'date_from'     => 'required|string',
            'date_to'       => 'required|string',
            'programId'     => 'required|numeric|min:1|exists:programs,id'
        ]);

        $table = Table::find($req->tableId);

        if (!$table) return redirect()->route('tables.index', [$req->courseId, $req->programId])->with('errorMsg', 'الجدول غير موجود !');

        $oldPDfSrc = $table->pdf_src;

        $src = $req->pdf ?  $req->pdf : $oldPDfSrc;

        if ($req->pdf) {
            // $src not $pdf because we want to override on the variable
            $src = sha1(time()) . "." . $req->pdf->getClientOriginalExtension();
            $req->pdf->move(public_path('/pdf'), $src);
        };

        $table->update([
            'week_number' => $req->week_number,
            'pdf_src' => $src,
            'date_from' => date('Y-m-d', strtotime($req->date_from)),
            'date_to' => date('Y-m-d', strtotime($req->date_to)),
            "program_id" => $req->programId
        ]);

        return redirect()->route('tables.index', [$req->route("courseId"), $req->programId])->with('successMsg', 'تم تعديل الجدول بنجاح');
    }


    public function destroy(Request $req)
    {
        $table = Table::find($req->tableId);

        if (!$table) return redirect()->route('tables.index', [$req->route("courseId"), $req->route("programId")])->with('errorMsg', 'الجدول غير موجود !');

        $table->delete();

        return redirect()->route('tables.index', [$req->route("courseId"), $req->route("programId")])->with('successMsg', 'تم حذف الجدول بنجاح');
    }
}