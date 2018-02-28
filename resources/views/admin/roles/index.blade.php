<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: index.blade.php
 * Author  : Li Tao
 * DateTime: 2018-02-07 07:34:00
 */
?>

@extends('admin.index')

@section('main')
    <div class="card">
        {!! Form::open(['id' => 'searchForm', 'method'=> 'POST', 'url' => 'admin/roles/search']) !!}
        <div class="card-header">
            @include('admin.roles.search')
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">名称</th>
                        <th scope="col">显示名称</th>
                        <th scope="col">描述</th>
                        <th scope="col">
                            @role('admin')
                            <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#create">
                                创建角色
                            </button>
                            @endrole
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($roles as $role)
                        <tr>
                            <th scope="row">{{ $role->id or 0 }}</th>
                            <td>{{ $role->name or '' }}</td>
                            <td>{{ $role->display_name or '' }}</td>
                            <td>{{ $role->description or '' }}</td>
                            <td>
                                <button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#view{{ $role->id or 0 }}">
                                    View
                                </button>
                                @ability('admin', 'edit_role', ['validate_all' => false,])
                                <button type="button" class="btn btn-outline-warning btn-sm" data-toggle="modal" data-target="#edit{{ $role->id or 0 }}">
                                    Edit
                                </button>
                                @endability
                                @if($role->name !== 'admin')
                                    @permission('delete_role')
                                    <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#delete{{ $role->id or 0 }}">
                                        Delete
                                    </button>
                                    @endpermission
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @include('common.pagination', ['url' => url('/admin/roles/page') . '/', 'page' => $pagination['page'], 'count' => $pagination['count'], 'type' => 'search'])
        {!! Form::close() !!}
        <div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="createTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                @include('admin.roles.create')
            </div>
        </div>
        @foreach($roles as $role)
            <div class="modal fade" id="view{{ $role->id or 0 }}" tabindex="-1" role="dialog" aria-labelledby="view{{ $role->id or 0 }}Title" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    @include('admin.roles.view')
                </div>
            </div>
            <div class="modal fade" id="edit{{ $role->id or 0 }}" tabindex="-1" role="dialog" aria-labelledby="edit{{ $role->id or 0 }}Title" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    @include('admin.roles.edit')
                </div>
            </div>
            <div class="modal fade" id="delete{{ $role->id or 0 }}" tabindex="-1" role="dialog" aria-labelledby="delete{{ $role->id or 0 }}Title" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    @include('admin.roles.delete')
                </div>
            </div>
        @endforeach
    </div>
@endsection
