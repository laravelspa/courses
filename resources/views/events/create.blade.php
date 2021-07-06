<x-app-layout>

    <x-slot name="headerTitle">
        <x-bread-link :link="true" route="dashboard" text="الصفحة الرئيسية"></x-bread-link>
        <x-bread-link :link="true" :bread="true" route="courses.index" text="الدورات"></x-bread-link>
        <x-bread-link :bread="true" text="انشاء دورة"></x-bread-link>
    </x-slot>

    <div class="col-11 col-sm-8 col-md-6 col-lg-4 mx-auto">
        <div class="create-course d-flex align-items-center justify-content-center">

            <!-- general form elements -->
            <div class="card card-primary w-100">
                <div class="card-header">
                    <h3 class="card-title w-100 text-right">انشاء دورة جديد</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" class="text-right" method="post" action="{{ route('courses.store') }}">
                    @csrf
                    @METHOD('POST')
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="اسم الدورة" value="{{ old('name') }}"
                                name="name" required>
                        </div>
                        <div class="form-group">
                            <input type="number" min="0" class="form-control" placeholder="عدد الطلاب"
                                value="{{ old('students_count') }}" name="students_count" required>
                        </div>

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
