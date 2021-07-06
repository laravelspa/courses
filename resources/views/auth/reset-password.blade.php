<x-guest-layout>

    <x-auth-validation-errors class="mb-4" :errors="$errors" />

    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">اعاده تعيين كلمة المرور</p>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="input-group mb-3">
                    <input type="email" class="form-control border-right-0 border-left" placeholder="البريد الاليكتروني"
                        value="{{ old('email', $request->email) }}" name="email" required autofocus>
                    <div class="input-group-append border-right border-left-0">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input type="password" class="form-control border-right-0 border-left"
                        placeholder="كلمة المرور الجديدة" name="password" required autofocus>
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
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">
                            ارسال
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.login-card-body -->
    </div>
    {{-- </x-auth-card> --}}
</x-guest-layout>
