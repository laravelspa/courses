@php
setlocale(LC_ALL, 'ar_EG.utf8');
use App\Models\User;
@endphp
<x-app-layout>
    <x-slot name="headerContent">
        <style>
            .fa-compress {
                display: none;
            }

            .fullscreen .fa-expand {
                display: none;
            }

            .fullscreen .fa-compress {
                display: inline;
            }

            #usersTable {
                margin-top: 0 !important;
            }

        </style>
    </x-slot>

    <x-slot name="headerTitle">
        <x-bread-link :link="true" route="dashboard" text="الصفحة الرئيسية"></x-bread-link>
        <x-bread-link :link="true" :route="'courses.index'" text="الدورات" :bread="true"></x-bread-link>
        <x-bread-link :bread="true" text="{{ $course->name }}"></x-bread-link>
        <x-bread-link :link="true" :route="'programs.index'" :routeParams="$course->id" text="البرامج" :bread="true" />
        <x-bread-link :bread="true" text="{{ $program->name }}"></x-bread-link>
    </x-slot>
    @can(User::P_ADD_TABLE)
        <div class="d-flex">
            <button class="btn btn-warning btn-sm mb-2 btnCreateTableModal">انشاء جدول</button>
        </div>
    @endcan
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table id="usersTable"
                    class="table table-tables table-hover text-right bg-white shadow-lg rounded-lg mt-0">
                    <thead class="bg-warning">
                        <tr>
                            <th>رقم الاسبوع</th>
                            <th>من التاريخ</th>
                            <th>الى التاريخ</th>
                            <th>التحكم</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tables as $table)
                            <tr>
                                <td>{{ $table->week_number }}</td>
                                <td>{{ $table->date_from }}</td>
                                <td>{{ $table->date_to }}</td>
                                <td class="d-flex align-items-center ">
                                    @can(User::P_EDIT_TABLE)
                                        <a href="" class="text-success ml-2 btnUpdateTableModal"
                                            data-week="{{ $table->week_number }}" data-date-to="{{ $table->date_to }}"
                                            data-date-from="{{ $table->date_from }}" data-programId="{{ $program->id }}"
                                            data-courseId="{{ $course->id }}" data-tableId="{{ $table->id }}">
                                            <i class="fa fa-edit fa-fw"></i>
                                        </a>
                                    @endcan
                                    @can(User::P_DELETE_TABLE)
                                        <!-- الموديل مش عايز يفتح يارب يولع -->
                                        <a class="text-danger mx-2 btnDeleteModal" data-toggle="modal"
                                            style="cursor: pointer" data-target="#deleteTableModal"
                                            data-tableId="{{ $table->id }}" data-programId={{ $program->id }}
                                            data-courseId="{{ $course->id }}"
                                            data-weekNumber="{{ $table->week_number }}">
                                            <i class="fa fa-trash-alt fa-fw"></i>
                                        </a>
                                    @endcan
                                    <a href="/pdf/{{ $table->pdf_src }}" class="text-info btnPdfReview"
                                        data-src="{{ $table->pdf_src }}"
                                        data-weekNumber="{{ $table->week_number }}">
                                        <i class="far fa-file-pdf fa-fw fa-lg"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{-- <div class="col-12 col-lg-6">
            <div class="card w-100" id="pdf" style="height: 600px;background-color:var(--teal)">
                <div class="card-header d-flex align-items-center justify-content-center">
                    <h3 class="card-title w-100 text-right">
                        @if ($tables->count() > 0)
                            عرض جدول الاسبوع رقم
                            <span class="badge badge-warning tableWeekNumber"></span>
                        @else
                            عرض الجدول
                        @endif
                    </h3>
                    <span style="cursor: pointer" onclick="handleScreen();">
                        <i class="fa fa-expand fa-fw fa-lg"></i>
                        <i class="fa fa-compress fa-fw fa-lg"></i>
                    </span>
                </div>
                <embed src="{{ asset('pdf/Mohamed aSobhi.pdf') }}" type="application/pdf" width="100%" height="100%"
                    id="embedRev">
            </div>
        </div> --}}
    </div>

    <x-custom-modal classes="createTableModal" headerVariant="warning">

        <x-slot name="title">
            انشاء جدول لـبرنامج :
            <span class="badge badge-info">{{ $program->name }}</span>
        </x-slot>
        <x-slot name="body">
            <!-- form start -->
            <form role="form" class="text-right" method="post"
                action="{{ route('tables.store', [$course->id, $program->id]) }}" id="formCreateTableModal"
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
                        <div id="date_from-hijri-tableCreate">
                            <input name="date_from">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="text-sm text-muted">التاريخ الى</label>
                        <div id="date_to-hijri-tableCreate">
                            <input name="date_to">
                        </div>
                    </div>

                    <div class=" input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="pdf" id="customFile" value="">
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

    <x-custom-modal classes="updateTableModal" headerVariant="success">

        <x-slot name="title">
            تعديل جدول لـبرنامج :
            <span class="badge badge-info">{{ $program->name }}</span>
        </x-slot>
        <x-slot name="body">
            <!-- form start -->
            <form role="form" class="text-right" method="post"
                action="{{ route('tables.update', [$course->id, $program->id]) }}" id="formUpdateTableModal"
                enctype="multipart/form-data">
                @csrf
                @METHOD('POST')
                <input type="hidden" class="inputTableId" required name="tableId">
                <div class="card-body">
                    <div class="form-group">
                        <input type="number" min="0" class="form-control inputWeekNumber" placeholder="رقم الاسبوع"
                            value="{{ old('week_number') }}" name="week_number" required>
                    </div>

                    <div class="form-group">
                        <label class="text-sm text-muted">التاريخ من</label>
                        <div id="date_from-hijri-tableUpdate">
                            <input name="date_from">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="text-sm text-muted">التاريخ الى</label>
                        <div id="date_to-hijri-tableUpdate">
                            <input name="date_to">
                        </div>
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
                    <button type="submit" class="btn btn-success">حفظ</button>
                </div>
            </form>
        </x-slot>
    </x-custom-modal>

    <div class="modal fade mt-5 deleteTableModal" id="deleteTableModal" tabindex="-1" role="dialog"
        aria-labelledby="deleteTableModalLabel" aria-hidden="true">
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
                        هل انت متأكد من حذف جدول الاسبوع رقم
                        <span class="badge badge-warning weekNumber"></span>
                        ؟
                    </h4>
                </div>
                <div class="p-3 d-flex justify-content-between align-items-center">
                    <div class="d-flex">
                        <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">الغاء</button>

                        <form action="" method="post" class="mx-2" id="formDelete">
                            @csrf
                            @METHOD('post')
                            <input type="hidden" value="" name="tableId" class="deleteId">
                            <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            var options = {
                lang: "ar"
            };
            $(function() {
                dataTablesFor('usersTable')

                $(document).on('click', ".btnDeleteModal", e => {
                    $("#formDelete").attr("action",
                        `/courses/${e.currentTarget.attributes["data-courseId"].value}/programs/${e.currentTarget.attributes["data-programId"].value}/tables/delete`
                    )
                    // formDelete
                    $(".deleteTableModal .weekNumber").text(e.currentTarget.attributes[
                        "data-weekNumber"].value)
                    $(".deleteId").val(e.currentTarget.attributes["data-tableId"].value)
                })

                $(document).on('click', ".btnCreateTableModal", e => {
                    e.preventDefault();
                    $(".createTableModal").modal("show");
                })

                $(document).on('click', ".btnUpdateTableModal", e => {
                    e.preventDefault();
                    $(".inputTableId").val(e.currentTarget.attributes["data-tableId"].value)
                    $("#date_from-hijri-tableUpdate input").val(e.currentTarget.attributes[
                        "data-date-from"].value)
                    $("#date_to-hijri-tableUpdate input").val(e.currentTarget.attributes["data-date-to"]
                        .value)
                    $(".inputWeekNumber").val(e.currentTarget.attributes["data-week"].value)

                    new HijriPicker("date_from-hijri-tableUpdate", options)
                    new HijriPicker("date_to-hijri-tableUpdate", options)

                    $(".updateTableModal").modal("show");
                })

                $(document).on('click', ".btnPdfReview", e => {
                    // e.preventDefault();
                    $("#embedRev").attr("src", window.location.origin + "/pdf/" + e.currentTarget
                        .attributes["data-src"].value)

                    $(".tableWeekNumber").text(e.currentTarget
                        .attributes["data-weekNumber"].value)
                })

                let table = document.querySelector(".table-tables");

                if (table) {

                    let firstRow = table.lastElementChild.firstElementChild;

                    if (firstRow) {

                        let btnReview = firstRow.lastElementChild.lastElementChild

                        if (btnReview) {

                            $("#embedRev").attr("src", window.location.origin + "/pdf/" + btnReview
                                .getAttribute(
                                    "data-src"))

                            $(".tableWeekNumber").text(btnReview.getAttribute("data-weekNumber"))
                        }

                    }
                }
            });

            new HijriPicker("date_from-hijri-tableCreate", options)
            new HijriPicker("date_to-hijri-tableCreate", options)

            var pdf = document.getElementById("pdf");

            function openFullscreen() {
                if (pdf.requestFullscreen) {
                    pdf.requestFullscreen();
                } else if (pdf.webkitRequestFullscreen) {
                    /* Safari */
                    pdf.webkitRequestFullscreen();
                } else if (pdf.msRequestFullscreen) {
                    /* IE11 */
                    pdf.msRequestFullscreen();
                }
            }

            /* Close fullscreen */
            function closeFullscreen() {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                } else if (document.webkitExitFullscreen) {
                    /* Safari */
                    document.webkitExitFullscreen();
                } else if (document.msExitFullscreen) {
                    /* IE11 */
                    document.msExitFullscreen();
                }
            }

            function handleScreen() {

                let isFullscreen = pdf.classList.contains("fullscreen");

                if (isFullscreen) closeFullscreen();
                else openFullscreen();

                pdf.classList.toggle("fullscreen");
            }

        </script>
    </x-slot>
</x-app-layout>
