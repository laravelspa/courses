<x-app-layout>
    <x-slot name="headerTitle">
        <x-bread-link :link="true" route="dashboard" text="الصفحة الرئيسية"></x-bread-link>
        <x-bread-link :link="true" :bread="true" route="settings.index" text="الإعدادات"></x-bread-link>
        <x-bread-link :bread="true" text="تعديل الإعدادات"></x-bread-link>
    </x-slot>
    <div class="col-12 col-md-8 col-lg-8 px-0 mx-auto">
        <div class="edit-setting d-flex align-items-center justify-content-center">
            <div class="card card-primary w-100">
                <div class="card-header">
                    <h3 class="card-title w-100 text-right">تعديل الإعدادات</h3>
                </div>
                <form method="POST" action="{{ route('settings.update', $settings->id) }}" role="form"
                    class="text-right" enctype="multipart/form-data">
                    @csrf
                    @METHOD('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" class="form-control" value="{{ $settings->name }}" name="name">
                        </div>
                        <div class="form-group">
                            <textarea type="text" class="form-control" name="welcome">{{ $settings->welcome }}
                            </textarea>
                        </div>
                        <div class="col-10 col-sm-6 col-lg-6 col-xl-4 mx-auto mb-3">
                            <img class="w-100" src="{{ asset('/logo/' . $settings->logo) }}"
                                alt="{{ $settings->name }}">
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
