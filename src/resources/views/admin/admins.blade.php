@extends('liddleforum::layout')

@section('liddleforum_content_inner')

    <h3>Admins</h3>
    <p>Manage your admins here. Note that if you create other admin accounts, they can remove you as an admin</p>

    @include('liddleforum::flashed.form_errors')

    <div class="row">
        <div class="col-md-offset-3 col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Admins</h3>
                </div>

                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th width="1%">User ID</th>
                        <th>Name</th>
                        <th width="1%">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($admins as $admin)
                        <tr>
                            <td>{{ $admin->user->getKey() }}</td>
                            <td>{{ $admin->user->{config('liddleforum.user.name_column')} }}</td>
                            <td>
                                @if(\Auth::user()->getKey() !== $admin->user_id)
                                    <form method="POST" action="{{ route('liddleforum.admin.admins.delete', ['id' => $admin->id]) }}">
                                        {!! csrf_field() !!}
                                        {!! method_field('DELETE') !!}
                                        <button class="btn btn-danger btn-sm">Remove</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div class="panel-footer">

                    <form method="POST" action="{{ route('liddleforum.admin.admins.create') }}">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <label for="user_id">User ID</label>
                            <input type="text" class="form-control" id="user_id" name="user_id" placeholder="User ID" value="{{ old('user_id', Request::get('user_id')) }}" />
                        </div>

                        <button class="btn btn-sm btn-success">Add Admin</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection