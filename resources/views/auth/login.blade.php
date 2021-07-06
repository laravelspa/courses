@php
setlocale(LC_ALL, 'ar_EG.utf8');
@endphp
<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="my-4 alert alert-success" :status="session('status')" />

    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">سجل الدخول لبدء الجلسة الخاصة بك</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" class="form-control border-right-0 border-left" placeholder="اسم المستخدم"
                        name="name" required autofocus>
                    <div class="input-group-append border-right border-left-0">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control border-right-0 border-left" name="password"
                        placeholder="كلمة المرور" autocomplete="current-password" required>
                    <div class="input-group-append border-right border-left-0">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">دخول</button>
                    </div>
                    <div class="col-8 text-right">
                        <div class="icheck-primary">
                            <label for="remember" class="text-sm">
                                تذكر كلمه المرور
                            </label>
                            <input type="checkbox" id="remember" name="remember">
                        </div>
                    </div>
                </div>
            </form>

            <div class="text-right mt-4">
                {{-- <p class="mb-1 text-sm">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-center">نسيت كلمة المرور؟</a>
                    @endif
                </p> --}}
                <p class="mb-0 text-sm">
                    <a href="{{ route('register') }}" class="text-center">تسجيل دخول جديد</a>
                </p>
            </div>
        </div>
        <!-- /.login-card-body -->
    </div>
</x-guest-layout>
