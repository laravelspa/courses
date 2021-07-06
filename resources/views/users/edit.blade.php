@php
$role = $user->roles[0]->name == 'admin' ? 1 : ($user->roles[0]->name == 'teacher' ? 0 : '');
@endphp
<x-app-layout>
    <div class="col-11 col-sm-8 col-md-6 col-lg-4 mx-auto">
        <div class="create-course d-flex align-items-center justify-content-center">
            <div class="card card-primary w-100">
                <div class="card-header">
                    <h3 class="card-title w-100 text-right">تعديل بيانات المستخدم</h3>
                </div>
                <form method="POST" action="{{ route('users.update', $user->id) }}" role="form" class="text-right">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="الاسم الاول"
                                value="{{ $user->firstname }}" name="firstname">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="الاسم الاخير"
                                value="{{ $user->lastname }}" name="lastname">
                        </div>
                        {{-- <div class="form-group">
                            <input type="email" class="form-control" placeholder="البريد الاليكتروني"
                                value="{{ $user->email }}" name="email">
                        </div> --}}
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="اسم المستخدم"
                                value="{{ $user->name }}" name="name">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="الهاتف" value="{{ $user->phone }}"
                                name="phone">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="كلمة المرور" name="password">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="تاكيد كلمة المرور"
                                name="password_confirmation">
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="userRole" placeholder="نوع المستخدم">
                                <option value="0" {{ $role == 0 ? 'selected' : '' }}>معلم</option>
                                <option value="1" {{ $role == 1 ? 'selected' : '' }}>مشرف</option>
                            </select>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">حفظ</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
