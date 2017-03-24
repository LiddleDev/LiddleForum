@if (session('liddleforum_error'))
    <div class="alert alert-danger">
        <p><i class="fa fa-exclamation-triangle"></i> <strong>Whoops!</strong> Something went wrong.</p>
        <p>{{ session('liddleforum_error') }}</p>
    </div>
@endif
@if (session('liddleforum_success'))
    <div class="alert alert-success">
        <p><i class="fa fa-exclamation-triangle"></i> <strong>Success!</strong></p>
        <p>{{ session('liddleforum_success') }}</p>
    </div>
@endif