@php
setlocale(LC_ALL, 'ar_EG.utf8');
use App\Models\User;
@endphp
<x-app-layout>
    <x-slot name="headerTitle">
        <x-bread-link :link="true" route="dashboard" text="الصفحة الرئيسية"></x-bread-link>
        <x-bread-link :bread="true" :link="true" route="courses.index" text="الدورات"></x-bread-link>
        <x-bread-link :bread="true" text="الطلاب"></x-bread-link>
    </x-slot>
    <div class="col-12">
        <div class=" alert-success text-sm position-absolute alert-dismissible fade show" role="alert" style="left:16px"
            id="studentsCreatedAlert" style="display:none;">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true" class="text-white">&times;</span>
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="table-responsive p-2">
                <div class="d-flex">
                    @can(User::P_ADD_STUDENT)
                        <button type="button" data-toggle="modal" data-target="#importExcelModal"
                            class="btn btn-warning btn-sm"><i class="fas fa-sm fa-plus"></i> استيراد الطلاب
                        </button>
                    @endcan
                </div>
                <table id="usersTable" class="table table-hover text-right bg-white rounded-lg">
                    <thead class="table-dark">
                        <tr>
                            <th>الرقم العسكري</th>
                            <th>اسم الطالب</th>
                            <th>القسم</th>
                            <th>الدوره التابع لها</th>
                            <th class="text-center">التحكم</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

            <div class="modal fade mt-5" id="updateStudentModal" tabindex="-1" role="dialog"
                aria-labelledby="updateStudentModalLabel" aria-hidden="true">
                <div class="modal-dialog pt-5" role="document">
                    <div class="modal-content">
                        <div class="modal-body p-0">
                            <div class="card card-success w-100 mb-0" style="margin-bottom: 0 !important">
                                <div class="card-header d-flex align-items-center justify-content-center">
                                    <h3 class="card-title w-100 text-right">
                                        تعديل الطالب :
                                        <span class="badge badge-primary studentName"> اسم الطالب</span>
                                    </h3>
                                    <span class="close text-white" data-dismiss="modal">&times;</span>
                                </div>
                                <form method="POST" action="" id="formUpdateStudentModal" role="form"
                                    class="text-right">
                                    @csrf
                                    @METHOD('POST')
                                    <input type="hidden" class="inputStudentId" value="" name="studentId" />
                                    <div class="card-body">
                                        <div class="form-group">
                                            <input type="text" class="form-control inputMilitaryNum"
                                                placeholder="الرقم العسكري" value="" name="military_num">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control inputStudentName"
                                                placeholder="اسم الطالب" value="" name="name">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control inputSection" placeholder="القسم"
                                                value="" name="section">
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-success">حفظ</button>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create Project Modal -->
        <div class="modal fade" id="importExcelModal" tabindex="-1" role="dialog"
            aria-labelledby="importExcelModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="card card-warning w-100 mb-0" style="margin-bottom: 0 !important">
                            <div class="card-header d-flex align-items-center justify-content-center">
                                <h3 class="card-title w-100 text-right">
                                    استيراد الطلاب
                                </h3>
                                <span class="close text-white" data-dismiss="modal">&times;</span>
                            </div>
                            <form id="formExcelModal" role="form" class="text-right">
                                <div class="card-body">
                                    <div class="form-group col-12">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="students_excel">
                                            <label class="custom-file-label" for="students_excel">Choose file</label>
                                        </div>
                                    </div>
                                    <div class="form-group col-12">
                                        <label class="font-weight-bold" for="course_uid">انتساب الى الدورة
                                            <select class="form-control pb-0" id="course_id">
                                                @foreach ($courses as $course)
                                                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                                                @endforeach
                                            </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm">حفظ</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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

                        <form action="" method="POST" class="mx-2" id="formDeleteStudentModal">
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
        <script>
            //Date range picker
            $('#reservation').daterangepicker();
            $(document).ready(function() {
                $('#usersTable').DataTable({
                    stateSave: true,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('students.ajax') }}",
                        method: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                    },
                    "columns": [{
                            "data": "military_num"
                        },
                        {
                            "data": "name"
                        },
                        {
                            "data": "section"
                        },
                        {
                            "data": "course_name"
                        },
                        {
                            "data": "actions"
                        }
                    ],
                    dom: 'lBfrtip',
                    language: {
                        search: '',
                        searchPlaceholder: "البحث عن",
                    },
                    buttons: [{
                            "extend": 'colvis',
                            "text": "<i class='fas fa-eye'></i>",
                            "title": '',
                            "collectionLayout": 'fixed two-column',
                            "className": "btn-sm btn-outline-dark",
                            "bom": "true",
                            init: function(api, node, config) {
                                $(node).removeClass("btn-secondary");
                            }
                        },
                        {
                            "extend": "csv",
                            "text": "<i class='fas fa-file-csv'></i>",
                            "title": '',
                            "filename": "Report Name",
                            "className": "btn-sm btn-outline-success",
                            "charset": "utf-8",
                            "bom": "true",
                            init: function(api, node, config) {
                                $(node).removeClass("btn-secondary");
                            }
                        },
                        {
                            "extend": "excel",
                            "text": "<i class='fas fa-file-excel'></i>",
                            "title": '',
                            "filename": "Report Name",
                            "className": "btn-sm btn-outline-danger",
                            "charset": "utf-8",
                            "bom": "true",
                            init: function(api, node, config) {
                                $(node).removeClass("btn-secondary");
                            },
                            exportOptions: {
                                columns: [':visible']
                            }
                        },
                        {
                            "extend": "print",
                            "text": "<i class='fas fa-file-pdf'></i>",
                            "title": '',
                            "filename": "Report Name",
                            "className": "btn-sm btn-outline-primary",
                            "charset": "utf-8",
                            "bom": "true",
                            init: function(api, node, config) {
                                $(node).removeClass("btn-secondary");
                            },
                            exportOptions: {
                                columns: [':visible']
                            }
                        },
                        {
                            "extend": "copy",
                            "text": "<i class='fas fa-copy'></i>",
                            "title": '',
                            "filename": "Report Name",
                            "className": "btn-sm btn-outline-info",
                            "charset": "utf-8",
                            "bom": "true",
                            init: function(api, node, config) {
                                $(node).removeClass("btn-secondary");
                            },
                            exportOptions: {
                                columns: [':visible']
                            }
                        }
                    ],
                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": true,
                    "responsive": false,
                }).buttons().container().appendTo('#usersTable_wrapper .col-md-6:eq(0)');

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

                const formExcelModal = $('#formExcelModal');
                if (formExcelModal) {
                    // Create Project Excel sheet
                    const LeadsExcel = $('#students_excel');

                    LeadsExcel.on('change', () => {
                        readXlsxFile(LeadsExcel[0].files[0]).then((data) => {
                            sessionStorage.setItem('students', JSON.stringify(data));
                        })
                    })

                    formExcelModal.on('submit', (e) => {
                        e.preventDefault();
                        const CourseId = $('#course_id').val();
                        if (sessionStorage.getItem('students') !== null) {
                            var formdata = new FormData();
                            formdata.append('_token', "{{ csrf_token() }}");
                            formdata.append('course_id', CourseId);
                            formdata.append('students', sessionStorage.getItem('students'));
                            $('#importExcelModal').modal('hide');

                            fetch("{{ route('students.import') }}", {
                                method: 'POST',
                                body: formdata
                            }).then(res => {
                                return res.json();
                            }).then(r => {
                                if (r.status === true) {
                                    $('#studentsCreatedAlert').append('<span>' + r.successMsg +
                                        '</span>');
                                    $('#studentsCreatedAlert').addClass('alert')
                                    $('#studentsCreatedAlert').css('display', 'block');
                                    $('#usersTable').DataTable().ajax.reload();
                                    formExcelModal[0].reset();
                                    sessionStorage.removeItem('students');
                                } else {
                                    $('#usersTable').DataTable().ajax.reload();
                                    formExcelModal[0].reset();
                                    sessionStorage.removeItem('students');
                                }
                            })
                        }
                    });
                }



                $(document).on('click', "#btnDeleteStudentModal", e => {
                    $("#formDeleteStudentModal").attr("action",
                        `/courses/${e.currentTarget.attributes["data-courseId"].value}/students/delete`
                    )
                    $(".deleteId").val(e.currentTarget.attributes["data-id"].value)
                    $("#studentNameDelete").text(e.currentTarget.attributes["data-name"].value)
                })

                $(".btnCreateStudentModal").click(e => {
                    e.preventDefault();
                    $(".createStudentModal").modal("show");
                })

                $(document).on('click', "#btnUpdateStudentModal", e => {
                    $("#formUpdateStudentModal").attr("action",
                        `/courses/${e.currentTarget.attributes["data-courseId"].value}/students/update`
                    )
                    $(".studentName").text(e.currentTarget.attributes["data-studentName"].value);
                    $(".inputStudentId").val(e.currentTarget.attributes["data-studentId"].value);
                    $(".inputStudentName").val(e.currentTarget.attributes["data-studentName"].value);
                    $(".inputSection").val(e.currentTarget.attributes["data-section"].value);
                    $(".inputMilitaryNum").val(e.currentTarget.attributes["data-military_num"].value);
                    // $(".inputStudentUid").val(e.currentTarget.attributes["data-studentUid"].value);
                    // $(".updateStudentModal").modal("show");
                })
            });

        </script>
    </x-slot>
</x-app-layout>
