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
        {!! Form::open(['id' => 'searchForm', 'method'=> 'POST', 'url' => 'admin/department/search']) !!}
        <div class="card-header">
            @include('admin.department.search')
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">部门</th>
                        <th scope="col">省</th>
                        <th scope="col">市</th>
                        <th scope="col">
                            <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#createPermission">
                                创建
                            </button>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($departmentList as $department)
                        <tr>
                            <th scope="row">{{ $department['id'] or 0 }}</th>
                            <td>{{ $department['name'] or '' }}</td>
                            <td>{{ $department['province_name'] or '' }}</td>
                            <td>{{ $department['city_name'] or '' }}</td>
                            <td>
                                <button type="button" class="btn btn-outline-warning btn-sm" data-toggle="modal" data-target="#edit{{ $department['id'] or 0 }}">
                                    修改
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#delete{{ $department['id'] or 0 }}">
                                    删除
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @include('common.pagination', ['url' => url('/admin/department/page') . '/', 'page' => $pagination['page'], 'count' => $pagination['count'], 'type' => 'search'])
        {!! Form::close() !!}
        <div class="modal fade" id="createPermission" tabindex="-1" role="dialog" aria-labelledby="createPermissionTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                @include('admin.department.create')
            </div>
        </div>
        @foreach($departmentList as $department)
            <div class="modal fade" id="edit{{ $department['id'] or 0 }}" tabindex="-1" role="dialog" aria-labelledby="edit{{ $department['id'] or 0 }}Title" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    @include('admin.department.edit')
                </div>
            </div>
            <div class="modal fade" id="delete{{ $department['id'] or 0 }}" tabindex="-1" role="dialog" aria-labelledby="delete{{ $department['id'] or 0 }}Title" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    @include('admin.department.delete')
                </div>
            </div>
        @endforeach
    </div>
@endsection
