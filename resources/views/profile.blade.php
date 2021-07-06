<x-app-layout>

    <x-slot name="headerTitle">
        <x-bread-link :link="true" route="dashboard" text="الصفحة الرئيسية"></x-bread-link>
        <x-bread-link :bread="true" text="البيانات الشخصية"></x-bread-link>
    </x-slot>

    <div class="col-11 col-sm-8 col-md-6 col-lg-4 mx-auto">
        <div class="create-course d-flex align-items-center justify-content-center">
            <div class="card card-primary w-100">
                <div class="card-header">
                    <h3 class="card-title w-100 text-right">تعديل البيانات الشخصية</h3>
                </div>
                <form method="POST" action="{{ route('profile.update') }}" role="form" class="text-right"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="الاسم الاول"
                                value="{{ auth()->user()->firstname }}" name="firstname">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="الاسم الاخير"
                                value="{{ auth()->user()->lastname }}" name="lastname">
                        </div>
                        {{-- <div class="form-group">
                            <input type="email" class="form-control" placeholder="البريد الاليكتروني"
                                value="{{ auth()->user()->email }}" name="email">
                        </div> --}}
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="اسم المستخدم"
                                value="{{ auth()->user()->name }}" name="name">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="الهاتف"
                                value="{{ auth()->user()->phone }}" name="phone">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="كلمة المرور" name="password">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="تاكيد كلمة المرور"
                                name="password_confirmation">
                        </div>
                        <div class="form-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="customFile" name="img">
                                <label class="custom-file-label" for="customFile">أختر الصورة</label>
                            </div>
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
