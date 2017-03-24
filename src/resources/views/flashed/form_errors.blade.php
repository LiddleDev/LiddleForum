@if (count($errors->liddleforum) > 0)
    <div class="alert alert-danger">
        <p><i class="fa fa-exclamation-triangle"></i> <strong>Whoops!</strong> There are some errors in your form.</p>
        <ul>
            @foreach ($errors->liddleforum->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif