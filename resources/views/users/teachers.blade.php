@php
use App\Models\User;
@endphp
<x-app-layout>
    <x-slot name="headerTitle">
        <x-bread-link :link="true" route="dashboard" text="الصفحة الرئيسية"></x-bread-link>
        <x-bread-link :bread="true" text="المعلمين"></x-bread-link>
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="table-responsive p-2">
                <div class="d-flex">
                    @can(User::P_ADD_USER)
                        <a type="button" href="" class="btn btn-primary btn-sm text-white btnCreateUserModal">
                            <i class="fas fa-plus"></i>
                            اضافة معلم
                        </a>
                    @endcan
                </div>
                <table id="usersTable" class="table table-hover text-right bg-white rounded-lg">
                    <thead class="table-dark">
                        <tr>
                            <th>الاسم الاول</th>
                            <th>الاسم الاخير</th>
                            <th>اسم المستخدم</th>
                            <th>الهاتف</th>
                            <th>الحالة</th>
                            <th>التحكم</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->firstname }}</td>
                                <td>{{ $user->lastname }}</td>
                                <td>{{ $user->name }}</td>
                                <td><a href="tel:{{ $user->phone }}">{{ $user->phone }}</a></td>
                                <td>
                                    @if ($user->active == 1)
                                        <span class="badge badge-success">مفعل</span>
                                    @else
                                        <span class="badge badge-danger">غير مفعل</span>
                                    @endif
                                </td>
                                <td class="d-flex align-items-center justify-content-between">
                                    @can(User::P_EDIT_USER)
                                        <div class="d-flex">
                                            <a href="" class="text-success btnUpdateUserModal"
                                                data-userId="{{ $user->id }}" data-username="{{ $user->name }}"
                                                data-firstname="{{ $user->firstname }}"
                                                data-lastname="{{ $user->lastname }}" data-phone="{{ $user->phone }}"
                                                data-userRole="{{ $user->userRole }}">
                                                <i class="fa fa-edit fa-fw"></i>
                                            </a>
                                            <a href="" class="text-danger mx-2 btnDeleteModal" data-toggle="modal"
                                                data-target="#deleteModal" data-name="{{ $user->name }}"
                                                data-id="{{ $user->id }}">
                                                <i class="fa fa-trash-alt fa-fw"></i>
                                            </a>
                                        </div>
                                        @if (!$user->active)
                                            <a href="" class="text-info btnApproveModal" data-toggle="modal"
                                                data-target="#approveModal" data-name="{{ $user->name }}"
                                                data-id="{{ $user->id }}">
                                                <i class="fa fa-check fa-fw"></i>
                                            </a>
                                        @else
                                            <a href="" class="text-danger btnNotApproveModal" data-toggle="modal"
                                                data-target="#notApproveModal" data-name="{{ $user->name }}"
                                                data-id="{{ $user->id }}">
                                                <i class="fa fa-times fa-fw"></i>
                                            </a>
                                        @endif
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="modal fade mt-5" id="notApproveModal" tabindex="-1" role="dialog"
                    aria-labelledby="notApproveModalLabel" aria-hidden="true">
                    <div class="modal-dialog  pt-5" role="document">
                        <div class="modal-content">
                            <div class="modal-body px-5 position-relative d-flex justify-content-center align-items-center"
                                style="margin-top:120px">
                                <div class="position-absolute bg-white rounded-circle d-flex justify-content-center align-items-center shadow-lg"
                                    style="width:160px;height:160px;top:-196px">
                                    <h1 class="mb-0 display-2 text-danger">
                                        <i class="fa fa-exclamation-triangle"></i>
                                    </h1>
                                </div>
                            </div>
                            <div class=" pb-4">
                                <h4 class="text-center">
                                    هل تريد بالفعل الغاء تفعيل المستخدم
                                    <span class="badge badge-warning notApproveUsername"></span>
                                    ؟
                                </h4>
                            </div>
                            <div class="p-3 d-flex justify-content-between align-items-center">
                                <div class="d-flex">
                                    <form action="{{ route('users.notApprove') }}" method="POST">
                                        @csrf
                                        <input type="hidden" value="" name="userId" class="notApproveInputId">
                                        <button type="submit" class="btn btn-danger btn-sm">موافق</button>
                                    </form>
                                </div>
                                <button type="button" class="btn btn-secondary btn-sm"
                                    data-dismiss="modal">الغاء</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade mt-5" id="approveModal" tabindex="-1" role="dialog"
                    aria-labelledby="approveModalLabel" aria-hidden="true">
                    <div class="modal-dialog  pt-5" role="document">
                        <div class="modal-content">
                            <div class="modal-body px-5 position-relative d-flex justify-content-center align-items-center"
                                style="margin-top:120px">
                                <div class="position-absolute bg-white rounded-circle d-flex justify-content-center align-items-center shadow-lg"
                                    style="width:160px;height:160px;top:-196px">
                                    <h1 class="mb-0 display-2 text-warning">
                                        <i class="fa fa-exclamation-triangle"></i>
                                    </h1>
                                </div>
                            </div>
                            <div class=" pb-4">
                                <h4 class="text-center">
                                    هل انت متأكد من الموافقه ع هذا المعلم ؟
                                    <span id="username" class="badge badge-warning"></span>
                                </h4>
                            </div>
                            <div class="p-3 d-flex align-items-center">
                                <form action="{{ route('users.approve') }}" method="POST">
                                    @csrf
                                    <input type="hidden" value="" name="userId" class="inputId">
                                    <input type="hidden" value="0" name="userRole">
                                    <input type="submit" value="تأكيد" class="btn btn-primary btn-sm"></input>
                                </form>
                                <button type="button" class="btn btn-secondary btn-sm mx-2"
                                    data-dismiss="modal">الغاء</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade mt-5" id="deleteModal" tabindex="-1" role="dialog"
                    aria-labelledby="deleteModalLabel" aria-hidden="true">
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
                                    هل انت متأكد من حذف المعلم
                                    <span id="usernameDelete" class="badge badge-danger"></span>
                                    ؟
                                </h4>
                            </div>
                            <div class="p-3 d-flex justify-content-between align-items-center">
                                <div class="d-flex">
                                    <button type="button" class="btn btn-primary btn-sm"
                                        data-dismiss="modal">الغاء</button>
                                    <form action="{{ route('users.delete') }}" method="POST" class="mx-2">
                                        @csrf
                                        <input type="hidden" value="" name="userId" class="deleteId">
                                        <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <x-custom-modal classes="createUserModal" headerVariant="primary">
                <x-slot name="title">اضافه معلم</x-slot>
                <x-slot name="body">
                    <form method="POST" action="{{ route('users.create') }}" role="form" class="text-right">
                        @csrf
                        @METHOD("POST")
                        <div class="card-body">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="الرتبة" value=""
                                    name="military_rank">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="الاسم الاول" value=""
                                    name="firstname">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="الاسم الاخير" value=""
                                    name="lastname">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="الوحدة" value=""
                                    name="military_unit">
                            </div>
                            {{-- <div class="form-group">
                        <input type="email" class="form-control" placeholder="البريد الاليكتروني"
                            value="{{ $user->email }}" name="email">
                    </div> --}}
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="اسم المستخدم" value="" name="name">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="الهاتف" value="" name="phone">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="كلمة المرور" name="password">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="تاكيد كلمة المرور"
                                    name="password_confirmation">
                            </div>
                            <input type="hidden" name="userRole" value="0">
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">حفظ</button>
                            </div>
                        </div>
                    </form>
                </x-slot>
            </x-custom-modal>
        </div>

        <x-custom-modal classes="updateUserModal" headerVariant="success">
            <x-slot name="title"> تعديل المعلم :
                <span class="badge badge-info username"></span>
            </x-slot>
            <x-slot name="body">
                <form method="POST" action="{{ route('users.update') }}" role="form" id="formUpdateUserModal"
                    class="text-right">
                    @csrf
                    @METHOD("POST")
                    <input type="hidden" value="" name="id" class="inputUserId" />
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" class="form-control inputFirstname" placeholder="الاسم الاول" value=""
                                name="firstname">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control inputLastname" placeholder="الاسم الاخير" value=""
                                name="lastname">
                        </div>
                        {{-- <div class="form-group">
                    <input type="email" class="form-control" placeholder="البريد الاليكتروني"
                        value="{{ $user->email }}" name="email">
                </div> --}}
                        <div class="form-group">
                            <input type="text" class="form-control inputUsername" placeholder="اسم المستخدم" value=""
                                name="name">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control inputPhone" placeholder="الهاتف" value=""
                                name="phone">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="كلمة المرور" name="password">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="تاكيد كلمة المرور"
                                name="password_confirmation">
                        </div>
                        <input type="hidden" name="userRole" value="0">
                        {{-- <div class="form-group">
                            <select class="form-control" name="userRole" placeholder="نوع المعلم">
                                <option value="0">معلم</option>
                                <option value="1">مشرف</option>
                            </select>
                        </div> --}}
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">حفظ</button>
                        </div>
                    </div>
                </form>
            </x-slot>
        </x-custom-modal>
    </div>

    <x-slot name="scripts">
        <script>
            $(function() {
                dataTablesFor('usersTable')

                $(document).on('click', ".btnApproveModal", e => {
                    $(".inputId").val(e.currentTarget.attributes["data-id"].value)
                    $("#username").text(e.currentTarget.attributes["data-name"].value)
                })

                $(document).on('click', ".btnDeleteModal", e => {
                    $(".deleteId").val(e.currentTarget.attributes["data-id"].value)
                    $("#usernameDelete").text(e.currentTarget.attributes["data-name"].value)
                })

                $(document).on('click', ".btnNotApproveModal", e => {
                    $(".notApproveInputId").val(e.currentTarget.attributes["data-id"].value)
                    $(".notApproveUsername").text(e.currentTarget.attributes["data-name"].value)
                })

                $(document).on('click', ".btnCreateUserModal", e => {
                    e.preventDefault();
                    $(".createUserModal").modal("show");
                })

                $(document).on('click', ".btnUpdateUserModal", e => {
                    e.preventDefault();

                    // $("#formUpdateUserModal").attr("action", `/users/update`);

                    $(".username").text(e.currentTarget.attributes["data-username"]?.value);
                    $(".inputUserId").val(e.currentTarget.attributes["data-userId"].value);
                    $(".inputUsername").val(e.currentTarget.attributes["data-username"]?.value);
                    $(".inputFirstname").val(e.currentTarget.attributes["data-firstname"]?.value);
                    $(".inputLastname").val(e.currentTarget.attributes["data-lastname"]?.value);
                    $(".military_unit").val(e.currentTarget.attributes["data-military_unit"]?.value);
                    $(".military_rank").val(e.currentTarget.attributes["data-military_rank"]?.value);
                    $(".inputPhone").val(e.currentTarget.attributes["data-phone"]?.value);
                    $(".updateUserModal").modal("show");
                })
            });

        </script>
    </x-slot>
</x-app-layout>
