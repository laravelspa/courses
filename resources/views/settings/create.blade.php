<x-app-layout>
    <x-slot name="headerTitle">
        <x-bread-link :link="true" route="dashboard" text="الصفحة الرئيسية"></x-bread-link>
        <x-bread-link :link="true" :bread="true" route="settings.index" text="الإعدادات"></x-bread-link>
        <x-bread-link :bread="true" text="إنشاء الإعدادات"></x-bread-link>
    </x-slot>
    <div class="col-11 col-sm-8 col-md-6 col-lg-8 mx-auto">
        <div class="create-setting d-flex align-items-center justify-content-center">
            <div class="card card-primary w-100">
                <div class="card-header">
                    <h3 class="card-title w-100 text-right">إضافة الإعدادات</h3>
                </div>
                <form method="POST" action="{{ route('settings.store') }}" role="form" class="text-right"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="أسم المعهد" name="name">
                        </div>
                        <div class="form-group">
                            <textarea type="text" class="form-control" name="welcome" placeholder="النص الترحيبى">
                            </textarea>
                        </div>
                        <div class="form-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="customFile" name="logo">
                                <label class="custom-file-label" for="customFile">أختر الصورة</label>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">حفظ</button>
                        </div>
                </form>
            </div>
        </div>
    </div>

</x-app-layout>
