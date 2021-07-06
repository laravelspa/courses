@php
setlocale(LC_ALL, 'ar_EG.utf8');
use App\Models\User;
@endphp
<x-app-layout>
    <x-slot name="headerTitle">
        <x-bread-link :link="true" route="dashboard" text="الصفحة الرئيسية"></x-bread-link>
        <x-bread-link :bread="true" :link="true" route="courses.index" text="الدورات"></x-bread-link>
        <x-bread-link :bread="true" text="{{ $course->name }}"></x-bread-link>
    </x-slot>

    <div class="row">
        <div class="col-12 {{-- col-md-8 col-lg-6 mx-auto --}}">

            <div class="table-responsive">
                <div class="d-flex">
                    @can(User::P_ADD_PROGRAM)
                        <a type="button" href="" class="btn btn-info btn-sm text-white btnCreateProgramModal">
                            <i class="fas fa-plus"></i>
                            اضافة برنامج
                        </a>
                    @endcan
                </div>
                <table id="usersTable" class="table table-hover text-right bg-white">
                    <thead class="table-dark">
                        <tr>
                            <th>رمز البرنامج</th>
                            <th>اسم البرنامج</th>
                            <th class="text-center">التحكم</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($programs as $program)
                            <tr>
                                <td>{{ $program->id }}</td>
                                <td>{{ $program->name }}</td>
                                <td class="d-flex align-items-center justify-content-center">
                                    @can(User::P_EDIT_PROGRAM)
                                        <a href="" class="text-success ml-2 btnUpdateProgramModal"
                                            data-name="{{ $program->name }}" data-courseId="{{ $course->id }}"
                                            data-programId="{{ $program->id }}">
                                            <i class="fa fa-edit fa-fw"></i>
                                        </a>
                                    @endcan
                                    @can(User::P_DELETE_PROGRAM)
                                        <a href="" class="text-danger mx-2 btnDeleteProgramModal" data-toggle="modal"
                                            data-target="#deleteModal" data-name="{{ $program->name }}"
                                            data-courseId="{{ $course->id }}" data-programId="{{ $program->id }}">
                                            <i class="fa fa-trash-alt fa-fw"></i>
                                        </a>
                                    @endcan
                                    @can(User::P_VIEW_TABLE)
                                        <a href="{{ route('tables.index', [$course->id, $program->id]) }}" class="ml-2">
                                            <span class="badge badge-warning p-1">
                                                <i class="fa fa-table fa-fw"></i>
                                                الجداول
                                            </span>
                                        </a>
                                    @endcan
                                    @can(User::P_ADD_TABLE)
                                        <a href="" class="text-info ml-2 btnCreateTableModal"
                                            data-courseId="{{ $course->id }}" data-programId="{{ $program->id }}"
                                            data-name="{{ $program->name }}">

                                            <span class="badge badge-warning p-1">
                                                <i class="fa fa-plus fa-fw"></i>
                                                انشاء جدول
                                            </span>
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>

        <x-custom-modal classes="updateProgramModal" headerVariant="success">

            <x-slot name="title"> تعديل برنامج :
                <span class="badge badge-info programName"> اسم البرنامج</span>
            </x-slot>
            <x-slot name="body">
                <form method="POST" action="" id="formUpdateProgramModal" role="form" class="text-right">
                    @csrf
                    @METHOD('POST')
                    <input type="hidden" class="inputProgramId" value="" name="programId" />
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" class="form-control inputProgramName" placeholder="اسم البرنامج" value=""
                                name="name">
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">حفظ</button>
                        </div>
                </form>
            </x-slot>

        </x-custom-modal>
    </div>

    <div class="modal fade mt-5" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog pt-5" role="document">
            <div class="modal-content">
                <div class="modal-body px-5 position-relative d-flex justify-content-center align-items-center"
                    style="margin-top:120px">
                    <div class="position-absolute bg-danger rounded-circle d-flex justify-content-center align-items-center shadow-lg"
                        style="width:160px;height:160px;top:-196px">
                        <h1 class="mb-0 display-2 text-white">
                            <i class="fa fa-times"></i>
                        </h1>
                    </div>
                </div>
                <div class="pb-4 px-3">
                    <h4 class="text-center">
                        هل انت متأكد من حذف البرنامج
                        <span id="programNameDelete" class="badge badge-danger"></span>
                        ؟
                    </h4>
                </div>
                <div class="p-3 d-flex justify-content-between align-items-center">
                    <div class="d-flex">
                        <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">الغاء</button>
                        <form action="" method="POST" class="mx-2" id="formDeleteProgramModal">
                            @csrf
                            @METHOD('POST')
                            <input type="hidden" value="" name="programId" class="deleteId">
                            <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-custom-modal classes="createTableModal" headerVariant="warning">

        <x-slot name="title">
            انشاء جدول لـبرنامج :
            <span class="badge badge-info programName"></span>
        </x-slot>
        <x-slot name="body">
            <!-- form start -->
            <form role="form" class="text-right" method="post" action="{{-- {{ route("programs.store", $course->id) }} --}}" id="formCreateTableModal"
                enctype="multipart/form-data">
                @csrf
                @METHOD('POST')
                <div class="card-body">
                    <div class="form-group">
                        <input type="number" min="0" class="form-control" placeholder="رقم الاسبوع"
                            value="{{ old('week_number') }}" name="week_number" required>
                    </div>

                    <div class="form-group">
                        <label class="text-sm text-muted">التاريخ من</label>
                        <input type="date" class="form-control" name="date_from" value="{{ date('Y-m-d') }}" required
                            min="2001-01-01" max="2050-01-01" />
                    </div>
                    <div class="form-group">
                        <label class="text-sm text-muted">التاريخ الى</label>
                        <input type="date" class="form-control" name="date_to" value="{{ date('Y-m-d') }}" required
                            min="2001-01-01" max="2050-01-01" />
                    </div>

                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="pdf" id="customFile">
                            <label class="custom-file-label" for="customFile">اختر ملف</label>
                        </div>
                        <div class="input-group-append">
                            <span class="input-group-text" id="">pdf</span>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-warning">حفظ</button>
                </div>
            </form>
        </x-slot>
    </x-custom-modal>

    <x-custom-modal classes="createProgramModal" headerVariant="info">

        <x-slot name="title"> اضافة برنامج لـدورة :
            <span class="badge badge-primary">{{ $course->name }}</span>
        </x-slot>
        <x-slot name="body">
            <form method="POST" action="{{ route('programs.store', $course->id) }}" role="form" class="text-right">
                @csrf
                @METHOD('POST')
                <div class="card-body">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="اسم البرنامج" value="" name="name">
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">حفظ</button>
                    </div>
            </form>
        </x-slot>

    </x-custom-modal>

    <x-slot name="scripts">
        <script>
            //Date range picker
            $('#reservation').daterangepicker();

            $(function() {
                dataTablesFor('usersTable');

                $(document).on('click', ".btnDeleteProgramModal", e => {
                    $(".deleteId").val(e.currentTarget.attributes["data-programId"].value)
                    $("#programNameDelete").text(e.currentTarget.attributes["data-name"].value)
                    $("#formDeleteProgramModal").attr("action",
                        `/courses/${e.currentTarget.attributes["data-courseId"].value}/programs/delete`
                    )

                })

                $(document).on('click', ".btnCreateTableModal", e => {
                    e.preventDefault();
                    $("#formCreateTableModal").attr("action",
                        `/courses/${e.currentTarget.attributes["data-courseId"].value}/programs/${e.currentTarget.attributes["data-programId"].value}/tables/create`
                    )
                    $(".createTableModal .programName").text(e.currentTarget.attributes["data-name"]
                        .value)
                    $(".createTableModal").modal("show");
                })

                $(document).on('click', ".btnCreateProgramModal", e => {
                    e.preventDefault();
                    $(".createProgramModal").modal("show");
                })

                $(document).on('click', ".btnUpdateProgramModal", e => {
                    e.preventDefault();
                    $("#formUpdateProgramModal").attr("action",
                        `/courses/${e.currentTarget.attributes["data-courseId"].value}/programs/update`
                    )
                    $(".programName").text(e.currentTarget.attributes["data-name"].value);
                    $(".inputProgramName").val(e.currentTarget.attributes["data-name"].value);
                    $(".inputProgramId").val(e.currentTarget.attributes["data-programId"].value);
                    $(".updateProgramModal").modal("show");
                })
            });

        </script>
    </x-slot>
</x-app-layout>
