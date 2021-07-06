@if ($settings)
    <img {{ $attributes }} src={{ asset($settings->logo ? 'logo/' . $settings->logo : 'img/AdminLTELogo.png') }}
        alt="{{ $settings->name }}" class="img-circle elevation-3 w-100" style="opacity: .8">
@else
    <img {{ $attributes }} src={{ asset('img/AdminLTELogo.png') }} alt="AdminLTE Logo"
        class="img-circle elevation-3 w-100" style="opacity: .8">
@endif
