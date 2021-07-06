<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function teachers()
    {
        $users = User::with("roles")->where("id", "!=", auth()->user()->id)->whereHas("roles", function ($query) {
            $query->whereIn("name", [User::R_TEACHER]);
        })->get();

        return view("users.teachers", ["users" => $users]);
    }

    public function all()
    {
        $users = User::with("roles")->where("id", "!=", auth()->user()->id)->whereHas("roles", function ($query) {
            $query->whereNotIn("name", [User::R_OWNER]);
        })->get();

        return view("users.users", ["users" => $users]);
    }


    // public function edit($id)
    // {
    //     $user = User::with("roles")->findOrFail($id);
    //     return view("users.edit", ["user" => $user]);
    // }


    public function notApprove(Request $req)
    {

        if (!auth()->user()->hasPermissionTo(User::P_EDIT_USER)) {
            return redirect()->route('dashboard')->with('errorMsg', 'عفوا, لا يوجد لديك صلاحيات للقيام بهذا الامر');
        }

        $user = User::find($req->userId);

        if (!$user) return redirect()->route('users')->with('errorMsg', 'المستخدم غير موجود !');

        $user->syncRoles(User::R_GUEST);

        $user->fill(['active' => 0]);

        $user->save();

        return redirect()->route('users')->with('successMsg', 'تم الغاء تفعيل المستخدم بنجاح');
    }

    public function approve(Request $req)
    {
        if (!auth()->user()->hasPermissionTo(User::P_EDIT_USER)) {
            return redirect()->route('dashboard')->with('errorMsg', 'عفوا, لا يوجد لديك صلاحيات للقيام بهذا الامر');
        }

        $user = User::findOrFail($req->userId);

        if ($req->post("userRole") == User::ADMIN) {
            $user->syncRoles(User::R_ADMIN);
        } else {
            $user->syncRoles(User::R_TEACHER);
        }

        $user->fill(['active' => 1]);

        $user->save();
        return redirect()->route('users')->with('successMsg', 'تم الموافقة على المستخدم بنجاح');
    }


    public function create(Request $req)
    {
        // dd($req);

        if (!auth()->user()->hasPermissionTo(User::P_ADD_USER)) {
            return redirect()->route('users')->with('errorMsg', 'عفوا, لا يوجد لديك صلاحيات للقيام بهذا الامر');
        }

        $req->validate([
            'firstname'     => 'required|string|max:255',
            'lastname'      => 'required|string|max:255',
            'military_rank' => 'string|max:255|nullable',
            'military_unit' => 'string|max:255|nullable',
            'img'           => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:4096|nullable',
            'name'          => 'required|string|max:255|unique:users,name',
            'phone'         => 'required|string|max:25',
            'password'      => 'required|string|confirmed|min:8|max:255',
            // 'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $data = [
            'name'          => trim($req->name),
            'firstname'     => trim($req->firstname),
            'lastname'      => trim($req->lastname),
            'military_rank' => $req->military_rank,
            'military_unit' => $req->military_unit,
            'phone'         => $req->phone,
            'password'      => Hash::make($req->password),
            // 'email'     => $req->email,
        ];

        if ($req->img) {
            $imageName = 'img_' . date('y_m_d_s_') . explode('.', explode(' ', microtime())[0])[1] . "." . $req->img->getClientOriginalExtension();
            $req->img->move(public_path('/profile'), $imageName);
            $data["img"] = $imageName;
        }

        $user = User::create($data);

        if ($req->userRole == User::ADMIN) {
            $user->syncRoles(User::R_ADMIN);
            // $user->syncPermissions([User::P_DEFAULT_ADMIN]);
        } elseif ($req->userRole == User::TEACHER) {
            $user->syncRoles(User::R_TEACHER);
            // $user->syncPermissions(User::P_DEFAULT_TEACHER);
        }

        return redirect()->route('users')->with('successMsg', 'تم اضافة المستخدم بنجاح');
    }

    public function update(Request $req)
    {

        if (!auth()->user()->hasPermissionTo(User::P_EDIT_USER)) {
            return redirect()->route('dashboard')->with('errorMsg', 'عفوا, لا يوجد لديك صلاحيات للقيام بهذا الامر');
        }

        $user = User::findOrFail($req->id);

        $req->validate([
            'firstname'     => 'required|string|max:255',
            'lastname'      => 'required|string|max:255',
            'name'          => 'required|string|max:255|unique:users,name,' . $user->id,
            'phone'         => 'required|string|max:25',
            'military_rank' => 'string|max:255|nullable',
            'military_unit' => 'string|max:255|nullable',
            'img'           => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:4096|nullable',
            // 'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password'      => 'nullable|string|confirmed|min:8|max:255',
        ]);


        $isOwner = $user->hasRole(User::R_OWNER);

        $isSelf = auth()->user()->id == $req->id;

        if ($isOwner || $isSelf) {
            return redirect()->route('dashboard')->with('errorMsg', 'عفوا, لا يوجد لديك صلاحيات للقيام بهذا الامر');
        }

        if ($req->userRole == User::ADMIN) {
            $user->syncRoles(User::R_ADMIN);
            // $user->syncPermissions([User::P_DEFAULT_ADMIN]);
        } elseif ($req->userRole == User::TEACHER) {
            $user->syncRoles(User::R_TEACHER);
            // $user->syncPermissions(User::P_DEFAULT_TEACHER);
        }

        $data = [
            'name'      => $req->name,
            'firstname' => $req->firstname,
            'lastname'  => $req->lastname,
            'military_rank' => $req->military_rank,
            'military_unit' => $req->military_unit,
            // 'email'     => $req->email,
            'phone'     => $req->phone,
        ];

        if ($req->password) {
            $data["password"] = Hash::make($req->password);
        }

        if ($req->img) {
            $imageName = 'img_' . date('y_m_d_s_') . explode('.', explode(' ', microtime())[0])[1] . "." . $req->img->getClientOriginalExtension();
            $req->img->move(public_path('/profile'), $imageName);
            $data["img"] = $imageName;
        }

        $user->fill($data);

        $user->save();

        return redirect()->route('users')->with('successMsg', 'تم حفظ التعديلات بنجاح');
    }


    public function profile()
    {
        return view("profile");
    }

    public function updateProfile(Request $req)
    {

        // dd($req->img);

        $user = User::findOrFail(auth()->user()->id);

        $req->validate([
            'firstname'     => 'required|string|max:255',
            'lastname'      => 'required|string|max:255',
            'name'          => 'required|string|max:255|unique:users,name,' . $user->id,
            'phone'         => 'required|string|max:25',
            'military_rank' => 'string|max:255|nullable',
            'military_unit' => 'string|max:255|nullable',
            'img'           => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:4096|nullable',
            'password'      => 'nullable|string|confirmed|min:8|max:255',
        ]);

        $data = [
            'name'      => $req->name,
            'firstname' => $req->firstname,
            'lastname'  => $req->lastname,
            'military_rank' => $req->military_rank,
            'military_unit' => $req->military_unit,
            // 'email'     => $req->email,
            'phone'     => $req->phone,
        ];

        if ($req->password) {
            $data["password"] = Hash::make($req->password);
        }

        if ($req->img) {
            $imageName = 'img_' . date('y_m_d_s_') . explode('.', explode(' ', microtime())[0])[1] . "." . $req->img->getClientOriginalExtension();
            $req->img->move(public_path('/profile'), $imageName);
            $data["img"] = $imageName;
        }

        $user->fill($data);

        $user->save();

        return redirect()->route('profile')->with('successMsg', 'تم حفظ التعديلات بنجاح');
    }


    public function delete(Request $req)
    {
        if (!auth()->user()->hasPermissionTo(User::P_DELETE_USER)) {
            return redirect()->route('dashboard')->with('errorMsg', 'عفوا, لا يوجد لديك صلاحيات للقيام بهذا الامر');
        }

        $user = User::findOrFail($req->userId);

        $isOwner = $user->hasRole(User::R_OWNER);

        $isSelf = auth()->user()->id == $req->userId;

        if ($isOwner || $isSelf) {
            return redirect()->route('dashboard')->with('errorMsg', 'عفوا, لا يوجد لديك صلاحيات للقيام بهذا الامر');
        }

        $user->delete();

        return redirect()->route('users')->with('successMsg', 'تم حذف المستخدم بنجاح');
    }
}