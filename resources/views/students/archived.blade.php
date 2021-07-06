@php
setlocale(LC_ALL, 'ar_EG.utf8');
@endphp
<x-app-layout>
    <x-slot name="headerTitle">
        <x-bread-link :link="true" route="dashboard" text="الصفحة الرئيسية"></x-bread-link>
        <x-bread-link :bread="true" text="الدورات المؤرشفة"></x-bread-link>
    </x-slot>

    <div class="table-responsive">
        <table id="usersTable" class="table table-hover text-right bg-white shadow-lg rounded-lg">
            <thead class="table-dark">
                <tr>
                    <th>اسم الدورة</th>
                    <th>عدد الطلاب</th>
                    <th>من التاريخ</th>
                    <th>الى التاريخ</th>
                    <th>التحكم</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($courses as $course)
                    <tr>
                        <td>{{ $course->name }}</td>
                        <td>{{ $course->students_count }}</td>
                        <td>{{ $course->date_from }}</td>
                        <td>{{ $course->date_to }}</td>
                        <td class="d-flex align-items-center justify-content-between">
                            <div>
                                <a href="{{ route('courses.edit', $course) }}" class="text-success ml-2">
                                    <i class="fa fa-edit fa-fw"></i>
                                </a>
                                <a href="" class="text-danger mx-2 btnDeleteModal" data-toggle="modal"
                                    data-target="#deleteModal" data-name="{{ $course->name }}"
                                    data-id="{{ $course->id }}">
                                    <i class="fa fa-trash-alt fa-fw"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
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
                        هل انت متأكد من حذف الدورات
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

    <x-slot name="scripts">
        <!-- DataTables -->
        <script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
        <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
        <script>
            $(function() {
                dataTablesFor('usersTable')

                $(".btnDeleteModal").click(e => {
                    $(".deleteId").val(e.currentTarget.attributes["data-id"].value)
                    $("#courseNameDelete").text(e.currentTarget.attributes["data-name"].value)
                })
            });

        </script>
    </x-slot>
</x-app-layout>
