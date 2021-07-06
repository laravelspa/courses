<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">اعاده تعيين كلمة المرور</p>

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="input-group mb-3">
                    <input type="email" class="form-control border-right-0 border-left" placeholder="البريد الاليكتروني"
                        value="{{ old('email') }}" name="email" required autofocus>
                    <div class="input-group-append border-right border-left-0">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">
                            رابط إعادة تعيين كلمة مرور البريد الإلكتروني
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.login-card-body -->
    </div>
    {{-- </x-auth-card> --}}
</x-guest-layout>
