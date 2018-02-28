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
        {!! Form::open(['id' => 'searchForm', 'method'=> 'POST', 'url' => 'admin/permissions/search']) !!}
        <div class="card-header">
            @include('admin.permissions.search')
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
                            <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#createPermission">
                                Create
                            </button>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($perms as $perm)
                        <tr>
                            <th scope="row">{{ $perm->id or 0 }}</th>
                            <td>{{ $perm->name or '' }}</td>
                            <td>{{ $perm->display_name or '' }}</td>
                            <td>{{ $perm->description or '' }}</td>
                            <td>
                                @permission('edit_permission')
                                <button type="button" class="btn btn-outline-warning btn-sm" data-toggle="modal" data-target="#editPermission{{ $perm->id or 0 }}">
                                    Edit
                                </button>
                                @endpermission
                                @permission('delete_permission')
                                <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#deletePermission{{ $perm->id or 0 }}">
                                    Delete
                                </button>
                                @endpermission
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @include('common.pagination', ['url' => url('/admin/permissions/page') . '/', 'page' => $pagination['page'], 'count' => $pagination['count'], 'type' => 'search', ])
        {!! Form::close() !!}
        <div class="modal fade" id="createPermission" tabindex="-1" role="dialog" aria-labelledby="createPermissionTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                @include('admin.permissions.create')
            </div>
        </div>
        @foreach($perms as $perm)
            <div class="modal fade" id="editPermission{{ $perm->id or 0 }}" tabindex="-1" role="dialog" aria-labelledby="editPermission{{ $perm->id or 0 }}Title" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    @include('admin.permissions.edit')
                </div>
            </div>
            <div class="modal fade" id="deletePermission{{ $perm->id or 0 }}" tabindex="-1" role="dialog" aria-labelledby="deletePermission{{ $perm->id or 0 }}Title" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    @include('admin.permissions.delete')
                </div>
            </div>
        @endforeach
    </div>
@endsection
