@php
setlocale(LC_ALL, 'ar_EG.utf8');
use App\Models\User;
@endphp
<x-app-layout>
    <x-slot name="headerTitle">
        <x-bread-link :link="true" route="dashboard" text="الصفحة الرئيسية"></x-bread-link>
        <x-bread-link :bread="true" text="الاحداث أو الأنشطة"></x-bread-link>
    </x-slot>

    <div class="row">
        <div class="col-12 {{-- col-md-8 col-lg-6 mx-auto --}}">

            <div class="table-responsive">
                <div class="d-flex">
                    @can(User::P_ADD_EVENT)
                        <a type="button" href="" class="btn btn-info btn-sm text-white btnCreateEventModal">
                            <i class="fas fa-plus"></i>
                            اضافة الحدث / النشاط
                        </a>
                    @endcan
                </div>
                <table id="usersTable" class="table table-hover text-right bg-white">
                    <thead class="table-dark">
                        <tr>
                            <th>رمز الحدث / النشاط</th>
                            <th>اسم الحدث / النشاط</th>
                            <th>مكان الحدث / النشاط</th>
                            <th>بدء الحدث / النشاط</th>
                            <th>انتهاء الحدث / النشاط</th>
                            <th class="text-center">التحكم</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($events as $event)
                            <tr>
                                <td>{{ $event->uid }}</td>
                                <td>{{ $event->name }}</td>
                                <td>{{ $event->where }}</td>
                                <td>{{ $event->date_from }}</td>
                                <td>{{ $event->date_to }}</td>
                                <td class="d-flex align-items-center justify-content-center">
                                    @can(User::P_EDIT_EVENT)
                                        <a href="" class="text-success ml-2 btnUpdateEventModal"
                                            data-id="{{ $event->id }}" data-uid="{{ $event->uid }}"
                                            data-name="{{ $event->name }}" data-ds="{{ $event->description }}"
                                            data-wh="{{ $event->where }}" data-event-df="{{ $event->date_from }}"
                                            data-event-dt="{{ $event->date_to }}">
                                            <i class="fa fa-edit fa-fw"></i>
                                        </a>
                                    @endcan
                                    @can(User::P_DELETE_EVENT)
                                        <a href="" class="text-danger mx-2 btnDeleteEventModal" data-toggle="modal"
                                            data-target="#deleteModal" data-name="{{ $event->name }}"
                                            data-id="{{ $event->id }}">
                                            <i class="fa fa-trash-alt fa-fw"></i>
                                        </a>
                                    @endcan
                                    @can(User::P_VIEW_EVENT)
                                        <a href="" class="text-info ml-2 btnViewModal"
                                            data-ds="{{ $event->description }}">

                                            <span class="badge badge-primary p-1">
                                                <i class="fa fa-eye fa-fw"></i>
                                                التفاصيل
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

        <x-custom-modal classes="updateEventModal" headerVariant="success">

            <x-slot name="title"> تعديل حدث / النشاط :
                <span class="badge badge-info eventName"> اسم الحدث / النشاط</span>
            </x-slot>
            <x-slot name="body">
                <form method="POST" action="" id="formUpdateEventModal" role="form" class="text-right">
                    @csrf
                    @METHOD('POST')
                    <input type="hidden" class="inputEventId" value="" name="id" />
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" class="form-control inputEventUid" placeholder="رمز الحدث / النشاط"
                                value="" name="uid" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control inputEventName" placeholder="اسم الحدث / النشاط"
                                value="" name="name" required>
                        </div>

                        <div class="form-group">
                            <textarea type="text" class="form-control inputEventDescription"
                                placeholder="وصف الحدث / النشاط" value="" name="description" required></textarea>
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control inputEventWhere" placeholder="مكان الحدث / النشاط"
                                value="" name="where" required>
                        </div>

                        <div class="form-group">
                            <label class="text-sm text-muted">التاريخ من</label>
                            <div id="date_from-hijri-evtUpdate">
                                <input name="date_from">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="text-sm text-muted">التاريخ الى</label>
                            <div id="date_to-hijri-evtUpdate">
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

    <div class="modal fade mt-5" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel"
        aria-hidden="true">
        <div class="modal-dialog pt-5" role="document">
            <div class="modal-content">
                <div class="modal-body px-5 position-relative py-0 d-flex justify-content-center align-items-center"
                    style="margin-top:120px">
                    <div class="position-absolute bg-primary rounded-circle d-flex justify-content-center align-items-center shadow-lg"
                        style="width:160px;height:160px;top:-196px">
                        <h1 class="mb-0 display-2 text-white">
                            <i class="fa fa-eye"></i>
                        </h1>
                    </div>
                </div>
                <div class="p-3 d-flex justify-content-center align-items-center">
                    <div class="text-center">
                        <h5 class="description"></h5>
                    </div>
                </div>
            </div>
        </div>
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
                        هل انت متأكد من حذف الحدث / النشاط
                        <span id="eventNameDelete" class="badge badge-danger"></span>
                        ؟
                    </h4>
                </div>
                <div class="p-3 d-flex justify-content-between align-items-center">
                    <div class="d-flex">
                        <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">الغاء</button>
                        <form action="" method="POST" class="mx-2" id="formDeleteEventModal">
                            @csrf
                            @METHOD('POST')
                            <input type="hidden" value="" name="id" class="deleteId">
                            <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-custom-modal classes="createEventModal" headerVariant="info">

        <x-slot name="title">
            انشاء جدول لـحدث / النشاط
        </x-slot>
        <x-slot name="body">
            <!-- form start -->
            <form role="form" class="text-right" method="post" id="formCreateEventModal"
                action="{{ route('events.store') }}">
                @csrf
                @METHOD('POST')
                <div class="card-body">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="رمز الحدث / النشاط"
                            value="{{ old('uid') }}" name="uid" required>
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="أسم الحدث / النشاط"
                            value="{{ old('name') }}" name="name" required>
                    </div>

                    <div class="form-group">
                        <textarea type="text" class="form-control" placeholder="وصف الحدث / النشاط"
                            value="{{ old('description') }}" name="description" required></textarea>
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="مكان الحدث / النشاط"
                            value="{{ old('where') }}" name="where" required>
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

            var options = {
                lang: "ar"
            };

            $(function() {
                dataTablesFor('usersTable');
                
                $(document).on('click', ".btnDeleteEventModal", e => {
                    $(".deleteId").val(e.currentTarget.attributes["data-id"].value)
                    $("#eventNameDelete").text(e.currentTarget.attributes["data-name"].value)
                    $("#formDeleteEventModal").attr("action",
                        `/events/delete`
                    )

                })

                $(document).on('click', ".btnCreateEventModal", e => {
                    e.preventDefault();
                    $(".createEventModal").modal("show");
                })

                $(document).on('click', ".btnViewModal", e => {
                    e.preventDefault();
                    $('.description').text(e.currentTarget.attributes["data-ds"].value);
                    $("#viewModal").modal("show");
                })

                $(document).on('click', ".btnUpdateEventModal", e => {
                    e.preventDefault();
                    $("#formUpdateEventModal").attr("action",
                        `/events/update`
                    )
                    $(".eventName").text(e.currentTarget.attributes["data-name"].value);
                    $(".inputEventName").val(e.currentTarget.attributes["data-name"].value);
                    $(".inputEventId").val(e.currentTarget.attributes["data-id"].value);
                    $(".inputEventUid").val(e.currentTarget.attributes["data-uid"].value);
                    $(".inputEventDescription").val(e.currentTarget.attributes["data-ds"].value);
                    $(".inputEventWhere").val(e.currentTarget.attributes["data-wh"].value);

                    $("#date_from-hijri-evtUpdate input").val(e.currentTarget.attributes[
                            "data-event-df"]
                        .value);
                    $("#date_to-hijri-evtUpdate input").val(e.currentTarget.attributes["data-event-dt"]
                        .value);

                    new HijriPicker("date_from-hijri-evtUpdate", options)
                    new HijriPicker("date_to-hijri-evtUpdate", options)

                    $(".updateEventModal").modal("show");
                })
            });

            new HijriPicker("date_from-hijri", options)
            new HijriPicker("date_to-hijri", options)

        </script>
    </x-slot>
</x-app-layout>
