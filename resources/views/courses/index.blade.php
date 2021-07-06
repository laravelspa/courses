@php
setlocale(LC_ALL, 'ar_EG.utf8');
use App\Models\User;
@endphp
<x-app-layout>
    <x-slot name="headerTitle">
        <x-bread-link :link="true" route="dashboard" text="الصفحة الرئيسية"></x-bread-link>
        <x-bread-link :bread="true" text="الدورات"></x-bread-link>
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <div class="d-flex">
                    @can(User::P_ADD_COURSE)
                        <a type="button" href="" class="btn btn-primary btn-sm text-white btnCreateCourseModal">
                            <i class="fas fa-plus"></i>
                            انشاء دورة
                        </a>
                    @endcan
                </div>
                <table id="usersTable" class="table table-hover text-right bg-white shadow-lg rounded-lg">
                    <thead class="table-dark">
                        <tr>
                            <th>رمز الدورة</th>
                            <th>رقم الدورة</th>
                            <th>اسم الدورة</th>
                            <th>عدد الطلاب</th>
                            <th>من التاريخ</th>
                            <th>الى التاريخ</th>
                            <th class="text-center">التحكم</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($courses as $course)
                            <tr>
                                <td>{{ $course->uid }}</td>
                                <td>{{ $course->course_number }}</td>
                                <td>{{ $course->name }}</td>
                                <td>{{ $course->students_count() }}</td>
                                <td>{{ $course->date_from }}</td>
                                <td>{{ $course->date_to }}</td>
                                <td class="d-flex align-items-center justify-content-center">
                                    @can(User::P_EDIT_COURSE)
                                        <a href="" class="text-success ml-2 btnUpdateCourseModal"
                                            data-courseId="{{ $course->id }}" data-courseUid="{{ $course->uid }}"
                                            data-courseName="{{ $course->name }}"
                                            data-courseNumber="{{ $course->course_number }}"
                                            data-course-df="{{ $course->date_from }}"
                                            data-course-dt="{{ $course->date_to }}"
                                            data-dateFrom="{{ $course->dateFrom }}"
                                            data-dateTo="{{ $course->dateTo }}">
                                            <!-- data-st-count="{{ $course->students_count() }}" -->
                                            <i class="fa fa-edit fa-fw"></i>
                                        </a>
                                    @endcan
                                    @can(User::P_DELETE_COURSE)
                                        <a href="" class="text-danger mx-2 btnDeleteCourseModal" data-toggle="modal"
                                            data-target="#deleteCourseModal" data-name="{{ $course->name }}"
                                            data-id="{{ $course->id }}">
                                            <i class="fa fa-trash-alt fa-fw"></i>
                                        </a>
                                    @endcan
                                    @can(User::P_VIEW_PROGRAM)
                                        <a href="{{ route('programs.index', $course->id) }}" class="ml-2">
                                            <span class="badge badge-info p-1">
                                                <i class="fa fa-tasks fa-fw"></i>
                                                البرامج
                                            </span>
                                        </a>
                                    @endcan
                                    @can(User::P_ADD_PROGRAM)
                                        <a href="" class="text-info ml-2 btnCreateProgramModal"
                                            data-courseId="{{ $course->id }}" data-courseName="{{ $course->name }}">

                                            <span class="badge badge-info p-1">
                                                <i class="fa fa-plus fa-fw"></i>
                                                اضافة برنامج
                                            </span>
                                        </a>
                                    @endcan
                                    @can(User::P_VIEW_STUDENT)
                                        <a href="{{ route('students.index', $course->id) }}" class="ml-2">
                                            <span class="badge badge-warning p-1">
                                                <i class="fa fa-users fa-fw"></i>
                                                الطلاب
                                            </span>
                                        </a>
                                    @endcan
                                    @can(User::P_ADD_STUDENT)
                                        <a href="" class="text-info ml-2 btnCreateStudentModal"
                                            data-courseId="{{ $course->id }}" data-courseName="{{ $course->name }}">

                                            <span class="badge badge-warning p-1">
                                                <i class="fa fa-plus fa-fw"></i>
                                                اضافة طالب
                                            </span>
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <x-custom-modal classes="updateCourseModal" headerVariant="success">
                    <x-slot name="title"> تعديل دورة :
                        <span class="badge badge-primary courseName"> اسم الدورة</span>
                    </x-slot>
                    <x-slot name="body">
                        <form method="POST" action="{{ route('courses.update') }}" id="formUpdateCourseModal"
                            role="form" class="text-right">
                            @csrf
                            @METHOD('POST')
                            <input type="hidden" class="inputCourseId" value="" name="id" />
                            <div class="card-body">
                                <div class="form-group">
                                    <input type="text" class="form-control inputCourseUid" placeholder="رمز الدورة"
                                        value="" name="uid">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control inputCourseName" placeholder="اسم الدورة"
                                        value="" name="name">
                                </div>
                                <div class="form-group">
                                    <input type="number" class="form-control inputCourseNumber" placeholder="رقم الدورة"
                                        value="" name="course_number">
                                </div>

                                <div class="form-group">
                                    <label class="text-sm text-muted">التاريخ من</label>
                                    <div id="date_from-hijri-update">
                                        <input name="date_from">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="text-sm text-muted">التاريخ الى</label>
                                    <div id="date_to-hijri-update">
                                        <input name="date_to">
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-success">حفظ</button>
                                </div>
                        </form>
                    </x-slot>
                </x-custom-modal>

            </div>

            <x-custom-modal classes="createProgramModal" headerVariant="info">
                <x-slot name="title">
                    انشاء برنامج لـدورة :
                    <span class="badge badge-primary courseName">اسم الدورة</span>
                </x-slot>
                <x-slot name="body">
                    <form method="POST" action="" role="form" class="text-right" id="formCreateProgramModal">
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

        </div>

        <x-custom-modal classes="createCourseModal">
            <x-slot name="title">انشاء دورة</x-slot>
            <x-slot name="body">
                <form method="POST" action="{{ route('courses.store') }}" role="form" class="text-right">
                    @csrf
                    @METHOD('POST')
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="رمز الدورة" value="" name="uid">
                        </div>
                        <div class="form-group">
                            <input type="number" min="1" class="form-control" placeholder="رقم الدورة" value=""
                                name="course_number">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="اسم الدورة" value="" name="name">
                        </div>

                        <div class="form-group">
                            <label class="text-sm text-muted">التاريخ من</label>
                            <div id="date_from-hijri">
                                <input name="date_from">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="text-sm text-muted">التاريخ الى</label>
                            <div id="date_to-hijri">
                                <input name="date_to">
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">حفظ</button>
                        </div>
                </form>
            </x-slot>
        </x-custom-modal>
    </div>

    <div class="modal fade mt-5" id="deleteCourseModal" tabindex="-1" role="dialog"
        aria-labelledby="deleteCourseModalLabel" aria-hidden="true">
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
                        هل انت متأكد من حذف الدورة
                        <span id="courseNameDelete" class="badge badge-danger"></span>
                        ؟
                    </h4>
                </div>
                <div class="p-3 d-flex justify-content-between align-items-center">
                    <div class="d-flex">
                        <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">الغاء</button>
                        <form action="{{ route('courses.destroy') }}" method="POST" class="mx-2">
                            @csrf
                            @METHOD('delete')
                            <input type="hidden" value="" name="courseId" class="deleteId">
                            <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-custom-modal classes="createStudentModal" headerVariant="warning">
        <x-slot name="title">
            اضافة طالب لـدورة :
            <span class="badge badge-primary courseName">اسم الدورة</span>
        </x-slot>
        <x-slot name="body">
            <form method="POST" action="" role="form" class="text-right" id="formCreateStudentModal">
                @csrf
                @METHOD('POST')
                <div class="card-body">
                    <div class="form-group">
                        <input type="text" class="form-control inputMilitaryNum" placeholder="الرقم العسكري"
                            value="{{ old('military_num') }}" name="military_num">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control inputStudentName" placeholder="اسم الطالب"
                            value="{{ old('name') }}" name="name">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control inputSection" placeholder="القسم"
                            value="{{ old('section') }}" name="section">
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-warning">حفظ</button>
                    </div>
            </form>
        </x-slot>
    </x-custom-modal>

    <x-slot name="scripts">
        <script>
            //Date range picker
            var options = {
                lang: "ar"
            };

            $(function() {
                dataTablesFor('usersTable');

                $(document).on('click', ".btnDeleteCourseModal", e => {
                    $(".deleteId").val(e.currentTarget.attributes["data-id"].value)
                    $("#courseNameDelete").text(e.currentTarget.attributes["data-name"].value)
                })

                $(document).on('click', ".btnCreateProgramModal", e => {
                    e.preventDefault();
                    $("#formCreateProgramModal").attr("action",
                        `/courses/${e.currentTarget.attributes["data-courseId"].value}/programs/create`
                    );

                    $(".createProgramModal .courseName").text(e.currentTarget.attributes[
                            "data-courseName"]
                        .value)
                    $(".createProgramModal").modal("show");
                })

                $(document).on('click', ".btnCreateStudentModal", e => {
                    e.preventDefault();
                    $("#formCreateStudentModal").attr("action",
                        `/courses/${e.currentTarget.attributes["data-courseId"].value}/students/create`
                    );

                    $(".createStudentModal .courseName").text(e.currentTarget.attributes[
                            "data-courseName"]
                        .value)
                    $(".createStudentModal").modal("show");
                })

                $(document).on('click', ".btnCreateCourseModal", e => {
                    e.preventDefault();
                    $(".createCourseModal").modal("show");
                })

                $(document).on('click', ".btnUpdateCourseModal", e => {
                    e.preventDefault();
                    $(".courseName").text(e.currentTarget.attributes["data-courseName"].value);
                    $(".inputCourseNumber").val(e.currentTarget.attributes["data-courseNumber"].value);
                    $(".inputCourseId").val(e.currentTarget.attributes["data-courseId"].value);
                    $(".inputCourseUid").val(e.currentTarget.attributes["data-courseUid"].value);
                    $(".inputCourseName").val(e.currentTarget.attributes["data-courseName"].value);
                    $("#date_from-hijri-update input").val(e.currentTarget.attributes["data-course-df"]
                        .value);
                    $("#date_to-hijri-update input").val(e.currentTarget.attributes["data-course-dt"]
                        .value);
                    // $(".inputCourseStCount").val(e.currentTarget.attributes["data-st-count"].value);
                    new HijriPicker("date_from-hijri-update", options)
                    new HijriPicker("date_to-hijri-update", options)
                    $(".updateCourseModal").modal("show");
                })
            });

            new HijriPicker("date_from-hijri", options)
            new HijriPicker("date_to-hijri", options)

        </script>
    </x-slot>
</x-app-layout>
