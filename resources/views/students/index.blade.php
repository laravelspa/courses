@php
setlocale(LC_ALL, 'ar_EG.utf8');
// dd($students);
use App\Models\User;
// dd();
// dd();
@endphp
<x-app-layout>
    <x-slot name="headerTitle">
        <x-bread-link :link="true" route="dashboard" text="الصفحة الرئيسية"></x-bread-link>
        <x-bread-link :bread="true" :link="true" route="courses.index" text="الدورات"></x-bread-link>
        <x-bread-link :bread="true" text="{{ $course->name }}"></x-bread-link>
        <x-bread-link :bread="true" text="الطلاب"></x-bread-link>
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <div class="d-flex">
                    @can(User::P_ADD_STUDENT)
                        <a type="button" href="" class="btn btn-warning btn-sm btnCreateStudentModal">
                            <i class="fas fa-plus"></i>
                            اضافة طالب لدوره
                            <span class="badge badge-primary">{{ $course->name }}</span>
                        </a>
                    @endcan
                </div>
                <table id="usersTable" class="table table-hover text-right bg-white shadow-lg rounded-lg">
                    <thead class="table-dark">
                        <tr>
                            <th>الرقم العسكري</th>
                            <th>اسم الطالب</th>
                            <th>القسم</th>
                            <th class="text-center">التحكم</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                            <tr>
                                <td>{{ $student->military_num }}</td>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->section }}</td>
                                <td class="d-flex align-items-center justify-content-center">
                                    @can(User::P_EDIT_STUDENT)
                                        <a href="" class="text-success ml-2 btnUpdateStudentModal"
                                            data-studentId="{{ $student->id }}" data-courseId="{{ $course->id }}"
                                            data-studentName="{{ $student->name }}"
                                            data-military_num="{{ $student->military_num }}"
                                            data-section="{{ $student->section }}"
                                            data-dateFrom="{{ $student->dateFrom }}"
                                            data-dateTo="{{ $student->dateTo }}">
                                            <!-- data-st-count="{{ $student->students_count }}" -->
                                            <i class="fa fa-edit fa-fw"></i>
                                        </a>
                                    @endcan
                                    @can(User::P_DELETE_STUDENT)
                                        <a href="" class="text-danger mx-2 btnDeleteStudentModal" data-toggle="modal"
                                            data-target="#deleteStudentModal" data-name="{{ $student->name }}"
                                            data-id="{{ $student->id }}">
                                            <i class="fa fa-trash-alt fa-fw"></i>
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <x-custom-modal classes="updateStudentModal" headerVariant="success">
                    <x-slot name="title"> تعديل الطالب :
                        <span class="badge badge-primary studentName"> اسم الطالب</span>
                    </x-slot>
                    <x-slot name="body">
                        <form method="POST" action="" id="formUpdateStudentModal" role="form" class="text-right">
                            @csrf
                            @METHOD('POST')
                            <input type="hidden" class="inputStudentId" value="" name="studentId" />
                            <div class="card-body">
                                <div class="form-group">
                                    <input type="text" class="form-control inputMilitaryNum" placeholder="الرقم العسكري"
                                        value="" name="military_num">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control inputStudentName" placeholder="اسم الطالب"
                                        value="" name="name">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control inputSection" placeholder="القسم" value=""
                                        name="section">
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-success">حفظ</button>
                                </div>
                        </form>
                    </x-slot>
                </x-custom-modal>

            </div>

        </div>

        <x-custom-modal classes="createStudentModal" headerVariant="warning">
            <x-slot name="title">
                اضافة طالب لـدورة :
                <span class="badge badge-primary courseName">{{ $course->name }}</span>
            </x-slot>
            <x-slot name="body">
                <form method="POST" action="{{ route('students.store', $course->id) }}" role="form"
                    class="text-right" id="formCreateStudentModal">
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

    </div>

    <div class="modal fade mt-5" id="deleteStudentModal" tabindex="-1" role="dialog"
        aria-labelledby="deleteStudentModalLabel" aria-hidden="true">
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
                        هل انت متأكد من حذف الطالب
                        <span id="studentNameDelete" class="badge badge-danger"></span>
                        ؟
                    </h4>
                </div>
                <div class="p-3 d-flex justify-content-between align-items-center">
                    <div class="d-flex">
                        <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">الغاء</button>
                        <form action="{{ route('students.destroy', $course->id) }}" method="POST" class="mx-2">
                            @csrf
                            @METHOD('POST')
                            <input type="hidden" value="" name="studentId" class="deleteId">
                            <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <!-- DataTables -->
        <script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
        <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
        <script>
            //Date range picker
            $('#reservation').daterangepicker();

            $(function() {
                $('#usersTable').DataTable({
                    "paging": true,
                    "lengthChange": false,
                    "searching": false,
                    "ordering": false,
                    "info": false,
                    "autoWidth": false,
                });
                $("#usersTable_next a").text("التالي");
                $("#usersTable_previous a").text("السابق");

                $("#usersTable_next a").click(() => {
                    $("#usersTable_next a").text("التالي");
                    $("#usersTable_previous a").text("السابق");
                })
                $("#usersTable_previous a").click(() => {
                    $("#usersTable_next a").text("التالي");
                    $("#usersTable_previous a").text("السابق");
                })

                $(".btnDeleteStudentModal").click(e => {
                    $(".deleteId").val(e.currentTarget.attributes["data-id"].value)
                    $("#studentNameDelete").text(e.currentTarget.attributes["data-name"].value)
                })

                $(".btnCreateStudentModal").click(e => {
                    e.preventDefault();
                    $(".createStudentModal").modal("show");
                })

                $(".btnUpdateStudentModal").click(e => {
                    e.preventDefault();

                    $("#formUpdateStudentModal").attr("action",
                        `/courses/${e.currentTarget.attributes["data-courseId"].value}/students/update`
                    )
                    $(".studentName").text(e.currentTarget.attributes["data-studentName"].value);
                    $(".inputStudentId").val(e.currentTarget.attributes["data-studentId"].value);
                    $(".inputStudentName").val(e.currentTarget.attributes["data-studentName"].value);
                    $(".inputSection").val(e.currentTarget.attributes["data-section"].value);
                    $(".inputMilitaryNum").val(e.currentTarget.attributes["data-military_num"].value);
                    // $(".inputStudentUid").val(e.currentTarget.attributes["data-studentUid"].value);
                    $(".updateStudentModal").modal("show");
                })
            });

        </script>
    </x-slot>
</x-app-layout>
