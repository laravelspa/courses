@props(['bread' => false, 'route' => '', 'text' => '', 'link' => false, 'routeParams' => false])

{{ $bread ? '/' : '' }}

@if (!$link)
    <span class="h6 mb-0 text-dark"> {{ $text }} </span>
@else
    <a class="h6 font-weight-bolder mb-0 text-primary"
        href="{{ $routeParams ? route($route, $routeParams) : route($route) }}"> {{ $text }} </a>
@endif
