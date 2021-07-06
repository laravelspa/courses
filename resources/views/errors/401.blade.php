<x-guest-layout>
    <div class="table-responsive">
          <!-- Main content -->
    <section class="content text-right">
      <div class="error-page">
        <h2 class="headline text-danger">401</h2>

        <div class="error-content">
          <h3><i class="fas fa-exclamation-triangle text-danger"></i>هذه الصفحة فقط للأشخاص الذين قاموا بتسجيل الدخول!!</h3>
        <a href="{{ route('dashboard') }}">العودة الى الصفحة الرئيسية</a>
        </div>
      </div>
      <!-- /.error-page -->
    </section>
    </div>
</x-guest-layout>
