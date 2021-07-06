@php
setlocale(LC_ALL, 'ar_EG.utf8');
@endphp
<x-guest-layout>
    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />
    <div class="card">
        <div class="card-body register-card-body">
            <p class="login-box-msg">تسجيل مستخدم جديد</p>

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" class="form-control border-right-0 border-left" name="firstname"
                        value="{{ old('firstname') }}" placeholder="الاسم الأول" autofocus required>
                    <div class="input-group-append border-right border-left-0">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control border-right-0 border-left" name="lastname"
                        value="{{ old('lastname') }}" placeholder="الاسم الاخير" autofocus required>
                    <div class="input-group-append border-right border-left-0">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                {{-- <div class="input-group mb-3">
                    <input type="email" class="form-control border-right-0 border-left" placeholder="البريد الاليكتروني"
                        value="{{ old('email') }}" name="email">
                    <div class="input-group-append border-right border-left-0">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div> --}}
                <div class="input-group mb-3">
                    <input type="name" class="form-control border-right-0 border-left" placeholder="اسم المستخدم"
                        value="{{ old('name') }}" name="name">
                    <div class="input-group-append border-right border-left-0">
                        <div class="input-group-text">
                            <span class="fas fa-user-circle"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="phone" class="form-control border-right-0 border-left" placeholder="رقم الهاتف"
                        value="{{ old('phone') }}" name="phone">
                    <div class="input-group-append border-right border-left-0">
                        <div class="input-group-text">
                            <span class="fas fa-phone"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control border-right-0 border-left" placeholder="كلمه المرور"
                        name="password" value="{{ old('password') }}">
                    <div class="input-group-append border-right border-left-0">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control border-right-0 border-left" name="password_confirmation"
                        placeholder="تأكيد كلمة المرور">
                    <div class="input-group-append border-right border-left-0">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">تسجيل</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <div class="text-right">
                <a href="{{ route('login') }}">لديك عضوية بالفعل؟</a>
            </div>
        </div>
        <!-- /.form-box -->
    </div><!-- /.card -->
    {{-- </x-auth-card> --}}
</x-guest-layout>
