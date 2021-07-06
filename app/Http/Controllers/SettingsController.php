<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingsController extends Controller
{

    public static function getSettings()
    {
        return DB::table('settings')->latest('created_at')->first();
    }

    public function index()
    {
        $settings = DB::table('settings')->first();
        // dd($settings);
        return view('settings.index')->withSettings($settings);
    }

    public function create()
    {
        return view('settings.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'welcome' => 'required|string|max:255',
            'logo' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = ['name'  => $request->name, 'welcome' => $request->welcome];

        if ($request->logo) {
            $imageName = 'logo.' . $request->logo->getClientOriginalExtension();
            $request->logo->move(public_path('/logo'), $imageName);
            $data["logo"] = $imageName;
        }

        Setting::create($data);

        return redirect()->route('settings.index')->with('successMsg', 'تم تعديل الإعدادات بنجاح');
    }

    public function edit($id)
    {
        $settings = Setting::find($id);
        return view('settings.edit')->withSettings($settings);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'welcome' => 'required|string|max:255',
            'logo' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = ["name" => $request->name, "welcome" => $request->welcome];

        if ($request->logo) {
            $imageName = 'logo.' . $request->logo->getClientOriginalExtension();
            $request->logo->move(public_path('/logo'), $imageName);
            $data["logo"] = $imageName;
        }


        $settings = Setting::find($id);

        $settings->fill($data);

        $settings->save();


        return redirect()->route('settings.index')->with('successMsg', 'تم تعديل الإعدادات بنجاح');
    }
}