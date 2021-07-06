@php
$sidebarItems = [
    [
        'iconClass' => 'fas fa-tachometer-alt',
        'title' => 'الصفحة الرئيسية',
        'route' => route('dashboard'),
        'isRoute' => true,
        'activeClass' => \Request::route()->getName() == 'dashboard' ? 'active' : '',
    ],
    [
        'iconClass' => 'fas fa-calendar',
        'title' => 'الأحداث / الأنشطة',
        'route' => route('events.index'),
        'isRoute' => true,
        'activeClass' => \Request::route()->getName() == 'events.index' ? 'active' : '',
    ],
    [
        'iconClass' => 'fas fa-th',
        'title' => 'الدورات الدراسية',
        'route' => route('courses.index'),
        'isRoute' => true,
        'activeClass' => \Request::route()->getName() == 'courses.index' ? 'active' : '',
    ],
    [
        'iconClass' => 'fas fa-user-graduate',
        'title' => 'الطلاب',
        'route' => route('students.all'),
        'isRoute' => true,
        'activeClass' => \Request::route()->getName() == 'students.all' ? 'active' : '',
    ],
    [
        'iconClass' => 'fa fa-chalkboard-teacher',
        'title' => 'المعلمين',
        'route' => route('teachers'),
        'isRoute' => true,
        'activeClass' => \Request::route()->getName() == 'teachers' ? 'active' : '',
    ],
    // [
    //     'iconClass' => 'fas fa-table',
    //     'title' => 'دورة نهاية الاسبوع',
    //     'route' => /* route('courses-week-end') */ '#',
    //     'isRoute' => true,
    //     'activeClass' => \Request::route()->getName() == 'courses-week-end' ? 'active' : '',
    // ],
    // [
    //     'iconClass' => 'fas fa-book',
    //     'title' => 'دورة المواقيف',
    //     'route' => /* route('courses-stopped') */ '#',
    //     'isRoute' => true,
    //     'activeClass' => \Request::route()->getName() == 'courses-stopped' ? 'active' : '',
    // ],
    // [
    //     'iconClass' => 'fas fa-archive',
    //     'title' => 'الدورات المؤرشفة',
    //     'route' => route('courses.archived'),
    //     'isRoute' => true,
    //     'activeClass' => \Request::route()->getName() == 'courses.archived' ? 'active' : '',
    // ],
    [
        'iconClass' => 'fas fa-users',
        'title' => 'المستخدمين',
        'route' => route('users'),
        'isRoute' => true,
        'activeClass' => \Request::route()->getName() == 'users' ? 'active' : '',
    ],
    ['title' => 'التحكم', 'isRoute' => false],
    // [
    //     'iconClass' => 'far fa-calendar-alt',
    //     'title' => 'انشاء دورة دراسي',
    //     'route' => route('courses.create'),
    //     'isRoute' => true,
    //     'activeClass' => \Request::route()->getName() == 'courses.create' ? 'active' : '',
    // ],
    // [
    //     'iconClass' => 'fas fa-table',
    //     'title' => 'انشاء دورة نهاية الاسبوع',
    //     'route' => /* route('courses-week-end.create') */ '#',
    //     'isRoute' => true,
    //     'activeClass' => \Request::route()->getName() == 'courses-week-end.create' ? 'active' : '',
    // ],
    // [
    //     'iconClass' => 'far fa-plus-square',
    //     'title' => 'انشاء دورة المواقيف',
    //     'route' => /* route('courses-stopped.create') */ '#',
    //     'isRoute' => true,
    //     'activeClass' => \Request::route()->getName() == 'courses-stopped.create' ? 'active' : '',
    // ],
    [
        'iconClass' => 'fa fa-wrench',
        'title' => 'الإعدادات',
        'route' => route('settings.index'),
        'isRoute' => true,
        'activeClass' => \Request::route()->getName() == 'settings.index' ? 'active' : '',
    ],
];

@endphp

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4 text-right">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">

        <div style="width:33px" class="d-inline-block">
            <x-application-logo></x-application-logo>
        </div>
        <span class="brand-text font-weight-light">{{ $settings ? $settings->name : 'Welcome' }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <a href="{{ route('profile') }}" class="d-flex text-capitalize">
                <div class="bg-white rounded-circle overflow-hidden {{ Auth::user()->img }}"
                    style="min-width:38px;max-width:38px; height:38px">
                    @if (Auth::user()->img)
                        <img src={{ asset('profile/' . Auth::user()->img) }} class="w-100">
                    @else
                        <img src={{ asset('profile/profile1.png') }} class="w-100 mt-1">
                    @endif
                </div>
                <div class="info">
                    <a href="{{ route('profile') }}">
                        {{ Auth::user()->firstname . ' ' . Auth::user()->lastname }}
                    </a>
                </div>
            </a>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @foreach ($sidebarItems as $item)
                    @if ($item['isRoute'])
                        <li class="nav-item">
                            <a href="{{ $item['route'] }}" class="nav-link {{ $item['activeClass'] }}">
                                <i class="nav-icon {{ $item['iconClass'] }}"></i>
                                <p>
                                    {{ $item['title'] }}
                                </p>
                            </a>
                        </li>
                    @else
                        <li class="nav-header">{{ $item['title'] }}</li>
                    @endif
                @endforeach
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <a class="nav-link text-light" href="{{ route('logout') }}"
                            onclick="event.preventDefault();this.closest('form').submit();">
                            <i class="nav-icon fa fa-sign-out-alt"></i>
                            <p>
                                تسجيل الحروج
                            </p>
                        </a>
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
