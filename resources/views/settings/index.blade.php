@php use App\Models\User; @endphp
<x-app-layout>
    <x-slot name="headerTitle">
        <x-bread-link :link="true" route="dashboard" text="الصفحة الرئيسية"></x-bread-link>
        <x-bread-link :bread="true" text="الإعدادات"></x-bread-link>
    </x-slot>

    <div class="col-12 col-lg-8 mx-auto">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title d-flex w-100 justify-content-between">
                    @can(User::P_ADD_SETTING)
                        <span class="text-right w-100">
                            الإعدادات
                        </span>
                        @if ($settings)
                            <a type="button" href="{{ route('settings.edit', $settings->id) }}"
                                class="btn btn-primary btn-xs text-white p-1 d-flex align-items-center align-items-center">
                                <i class="fas fa-edit"></i>
                                <span class="pl-2">تعديل</span>
                            </a>
                        @else
                            <a type="button" href="{{ route('settings.create') }}"
                                class="btn btn-success btn-xs text-white p-1 d-flex align-items-center align-items-center">
                                <i class="fas fa-plus"></i>
                                <span class="pl-2">إضافة</span>
                            </a>
                        @endif
                    @endcan
                </h3>
            </div>
            <div class="card-body pad table-responsive">
                @if ($settings)
                    {{-- <div class="create-course d-flex align-items-center justify-content-center"> --}}
                    {{-- <div class="card card-primary w-100"> --}}
                    {{-- <div class="card-header"> --}}
                    {{-- <h3 class="card-title w-100 text-right">الإعدادات</h3> --}}
                    {{-- </div> --}}
                    {{-- <div class="card-body"> --}}
                    <div class="form-group">
                        <input type="text" class="form-control" value="{{ $settings->name }}" placeholder="أسم المعهد"
                            disabled>
                    </div>
                    <div class="form-group">
                        <textarea type="textarea" class="form-control" placeholder="نص ترحيبى"
                            disabled>{{ $settings->welcome }}</textarea>
                    </div>
                    <div class="form-group text-center">
                        <img width="300" height="300" src="{{ asset('/logo/' . $settings->logo) }}"
                            alt="{{ $settings->logo ? $settings->name : 'لم تقم بتعيين اللوجو' }}">
                    </div>
                    {{-- </div> --}}
                    {{-- </div> --}}
                    {{-- </div> --}}
                    {{-- </div> --}}
                @else
                    <div class="text-center">
                        <h4 class="badge badge-danger p-2">لم تقم بتعيين الإعدادات حتى الأن</h4>
                    </div>
                @endif
            </div>
            <!-- /.card -->
        </div>
    </div>
</x-app-layout>
