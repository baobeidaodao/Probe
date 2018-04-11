<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: index.blade.php
 * Author  : Li Tao
 * DateTime: 2018-02-10 23:59:00
 */
?>

@extends('admin.index')

@section('main')
    <div class="card">
        {!! Form::open(['id' => 'searchForm', 'method'=> 'POST', 'url' => 'admin/users/search']) !!}
        <div class="card-header">
            @include('admin.users.search')
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">姓名</th>
                        <th scope="col">级别</th>
                        <th scope="col">省份</th>
                        <th scope="col">Email</th>
                        <th scope="col">电话</th>
                        <th scope="col">
                            <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#createUser">
                                创建
                            </button>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <th scope="row">{{ $user->id or 0 }}</th>
                            <td>{{ $user->name or '' }}</td>
                            <td>
                                @foreach($userLevelList as $userLevel)
                                    @if($userLevel['id'] == $user->level) {{ $userLevel['name'] or '' }} @endif
                                @endforeach
                            </td>
                            <td>
                                @foreach($areaMap as $province)
                                    @if(isset($province['level']) && $province['level'] == \App\Models\Area::LEVEL_PROVINCE)
                                        @if($province['id'] == $user->province_id) {{ $province['name'] or '' }} @endif
                                    @endif
                                @endforeach
                            </td>
                            <td>{{ $user->email or '' }}</td>
                            <td>{{ $user->phone or '' }}</td>
                            <td>
                                @if(Auth::getUser()->level < $user->level || Auth::id() == $user->id)
                                    <button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#viewUser{{ $user->id or 0 }}">
                                        查看
                                    </button>
                                    @ability('admin', 'edit_user', ['validate_all' => false,])
                                    @if(Auth::getUser()->level < $user->level || Auth::id() == $user->id)
                                        <button type="button" class="btn btn-outline-warning btn-sm" data-toggle="modal" data-target="#editUser{{ $user->id or 0 }}">
                                            修改
                                        </button>
                                    @endif
                                    @endability
                                    @if($user->name !== 'admin' && Auth::getUser()->level < $user->level)
                                        @permission('delete_user')
                                        <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#deleteUser{{ $user->id or 0 }}">
                                            删除
                                        </button>
                                        @endpermission
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @include('common.pagination', ['url' => url('/admin/users/page') . '/', 'page' => $pagination['page'], 'count' => $pagination['count'], 'type' => 'search'])
        {!! Form::close() !!}
        <div class="modal fade" id="createUser" tabindex="-1" role="dialog" aria-labelledby="createUserTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                @include('admin.users.create')
            </div>
        </div>
        @foreach($users as $user)
            <div class="modal fade bd-example-modal-lg" id="viewUser{{ $user->id or 0 }}" tabindex="-1" role="dialog" aria-labelledby="viewUser{{ $user->id or 0 }}Title" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    @include('admin.users.view')
                </div>
            </div>
            <div class="modal fade" id="editUser{{ $user->id or 0 }}" tabindex="-1" role="dialog" aria-labelledby="editUser{{ $user->id or 0 }}Title" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    @include('admin.users.edit')
                </div>
            </div>
            <div class="modal fade" id="deleteUser{{ $user->id or 0 }}" tabindex="-1" role="dialog" aria-labelledby="deleteUser{{ $user->id or 0 }}Title" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    @include('admin.users.delete')
                </div>
            </div>
        @endforeach
    </div>
    <script>
        var departmentListJson = '<?php echo json_encode($departmentList); ?>';
        var departmentList = JSON.parse(departmentListJson);
    </script>
@endsection
