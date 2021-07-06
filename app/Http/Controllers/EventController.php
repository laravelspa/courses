<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return view('events.index', ["events" => $events]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'uid' => 'required|string',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'where' => 'required|string',
            'date_from' => 'required|string',
            'date_to' => 'required|string',
        ]);

        Event::create([
            'uid' => $request->uid,
            'name' => $request->name,
            'description' => $request->description,
            'where' => $request->where,
            'date_from' => date('Y-m-d', strtotime($request->date_from)),
            'date_to' => date('Y-m-d', strtotime($request->date_to)),
        ]);

        return redirect()->route('events.index')->with('successMsg', 'تم إنشاء الحدث / النشاط بنجاح');
    }


    public function update(Request $request)
    {
        $request->validate([
            'uid' => 'required|string',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'where' => 'required|string',
            'date_from' => 'required|string',
            'date_to' => 'required|string',
        ]);

        $event = Event::find($request->id);

        if (!$event) return redirect()->route('events.index')->with('errorMsg', 'الحدث / النشاط غير موجودة !');

        $event->update([
            'uid' => $request->uid,
            'name' => $request->name,
            'description' => $request->description,
            'where' => $request->where,
            'date_from' => date('Y-m-d', strtotime($request->date_from)),
            'date_to' => date('Y-m-d', strtotime($request->date_to)),
        ]);

        return redirect()->route('events.index')->with('successMsg', 'تم تعديل الحدث / النشاط بنجاح');
    }


    public function destroy(Request $request)
    {
        Event::find($request->id)->delete();
        return redirect()->route('events.index')->with('successMsg', 'تم حذف الحدث / النشاط بنجاح');
    }

    /** 
     * Archeive Events
     */
    // public function archived()
    // {
    //     $today = date('Y-m-d');
    //     $events = Event::where('date_to', '<', $today)->get();
    //     return view('events.archived')->withEvents($events);
    // }
}