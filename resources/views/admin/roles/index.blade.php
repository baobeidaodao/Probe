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
                            <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#createRole">
                                创建角色
                            </button>
                            <div class="modal fade" id="createRole" tabindex="-1" role="dialog" aria-labelledby="createRoleTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    @include('admin.roles.create')
                                </div>
                            </div>
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
                                <button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#viewRole{{ $loop->iteration }}">
                                    View
                                </button>
                                <div class="modal fade" id="viewRole{{ $loop->iteration }}" tabindex="-1" role="dialog" aria-labelledby="viewRole{{ $loop->iteration }}Title" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        @include('admin.roles.view')
                                    </div>
                                </div>
                                @ability('admin', 'edit_role', ['validate_all' => false,])
                                <button type="button" class="btn btn-outline-warning btn-sm" data-toggle="modal" data-target="#editRole{{ $loop->iteration }}">
                                    Edit
                                </button>
                                <div class="modal fade" id="editRole{{ $loop->iteration }}" tabindex="-1" role="dialog" aria-labelledby="editRole{{ $loop->iteration }}Title" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        @include('admin.roles.edit')
                                    </div>
                                </div>
                                @endability
                                @if($role->name !== 'admin')
                                    @permission('delete_role')
                                    <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#deleteRole{{ $loop->iteration }}">
                                        Delete
                                    </button>
                                    <div class="modal fade" id="deleteRole{{ $loop->iteration }}" tabindex="-1" role="dialog" aria-labelledby="deleteRole{{ $loop->iteration }}Title" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            @include('admin.roles.delete')
                                        </div>
                                    </div>
                                    @endpermission
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @include('common.pagination', ['url' => url('/admin/roles/page') . '/', 'page' => $pagination['page'], 'count' => $pagination['count'],])
    </div>
@endsection
