@extends('liddleforum::layout')

@section('liddleforum_content_inner')

    <h3>Moderators</h3>
    <p>Manage your moderators here. Either create global moderators or limit moderators' powers to specific categories and their subcategories.</p>

    <div class="row">
        <div class="col-md-offset-3 col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Moderators</h3>
                </div>

                @if(count($moderators))

                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th width="1%">User ID</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th width="1%">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($moderators as $moderator)
                            <tr>
                                <td>{{ $moderator->user->getKey() }}</td>
                                <td>{{ $moderator->user->{config('liddleforum.user.name_column')} }}</td>
                                <td>
                                    @if($moderator->category)
                                        {{ $moderator->category->name }}
                                    @else
                                        <strong>Global</strong>
                                    @endif
                                </td>
                                <td>
                                    <form method="POST" action="{{ route('liddleforum.admin.moderators.delete', ['id' => $moderator->id]) }}">
                                        {!! csrf_field() !!}
                                        {!! method_field('DELETE') !!}
                                        <button class="btn btn-danger btn-sm">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                @else

                    <div class="panel-body">
                        There are currently no moderators, add them below.
                    </div>

                @endif

                <div class="panel-footer">
                    <form method="POST" action="{{ route('liddleforum.admin.moderators.create') }}">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <label for="user_id">User ID</label>
                            <input type="text" class="form-control" id="user_id" name="user_id" placeholder="User ID" value="{{ old('user_id', Request::get('user_id')) }}" />
                        </div>

                        <div class="form-group">
                            <label for="category">Category</label>
                            <select id="category" name="category" class="form-control">
                                <option value="">- Global -</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @if(old('category', Request::get('category')) === $category->id) selected @endif>{{ $category->getDropdownName() }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button class="btn btn-sm btn-success">Add Mod</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection