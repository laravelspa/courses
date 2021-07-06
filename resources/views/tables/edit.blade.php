<x-app-layout>
    <x-slot name="headerTitle">
        <x-bread-link :link="true" route="dashboard" text="الصفحة الرئيسية"></x-bread-link>
        <x-bread-link :link="true" :bread="true" route="courses.index" text="الدورات"></x-bread-link>
        <x-bread-link :bread="true" text="{{ $course->name }}"></x-bread-link>
        <x-bread-link :bread="true" text=" الأسبوع رقم {{ $table->week_number }}"></x-bread-link>
    </x-slot>

    <div class="col-11 col-sm-8 col-md-6 col-lg-4 mx-auto">
        <div class="create-course d-flex align-items-center justify-content-center">

            <!-- general form elements -->
            <div class="card card-primary w-100">
                <div class="card-header">
                    <h3 class="card-title w-100 text-right">تعديل الأسبوع {{ $table->week_number }}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" class="text-right" method="post"
                    action="{{ route('tables.update', [$course, $table]) }}" enctype="multipart/form-data">
                    @csrf
                    @METHOD('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <input type="number" min="0" class="form-control" placeholder="رقم الاسبوع"
                                value="{{ $table->week_number }}" name="week_number" required>
                        </div>

                        <!-- Date range -->
                        <div class="form-group">
                            <label>التاريخ من - الى</label>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="far fa-calendar-alt"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control float-right" id="reservation" name="date"
                                    value="{{ old('date') }}" required>
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
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">حفظ</button>
                        </div>
                </form>
            </div>
            <!-- /.card -->
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            //Date range picker
            $('#reservation').daterangepicker()

        </script>
    </x-slot>

</x-app-layout>
