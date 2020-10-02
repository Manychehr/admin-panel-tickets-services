
@if ($errors->any())
<!-- Danger Alert -->
<div class="alert alert-danger alert-dismissable" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    <h3 class="alert-heading font-size-h4 font-w400">Error</h3>
    @foreach ($errors->all() as $error)
        <p class="mb-0">{{ $error }}</p>
    @endforeach
</div>
<!-- END Danger Alert -->
@endif

@if(session('success'))
    <!-- Success Alert -->
<div class="alert alert-success alert-dismissable" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    <h3 class="alert-heading font-size-h4 font-w400">Success</h3>
    <p class="mb-0">{{ session('success') }}</p>
</div>
<!-- END Success Alert -->
@endif
