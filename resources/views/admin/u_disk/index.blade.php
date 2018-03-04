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
        {!! Form::open(['id' => 'searchForm', 'method'=> 'POST', 'url' => 'admin/u-disk/search']) !!}
        <div class="card-header">
            @include('admin.u_disk.search')
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">UUID</th>
                        <th scope="col">人员</th>
                        <th scope="col">运营商</th>
                        <th scope="col">
                            <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#createUDisk">
                                创建
                            </button>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($uDiskList as $uDisk)
                        <tr>
                            <th scope="row">{{ $uDisk['id'] or 0 }}</th>
                            <td>{{ $uDisk['uuid'] or '' }}</td>
                            <td>{{ $uDisk['user_name'] or '' }}</td>
                            <td>{{ $uDisk['operator_name'] or '' }}</td>
                            <td>
                                <button type="button" class="btn btn-outline-warning btn-sm" data-toggle="modal" data-target="#editUDisk{{ $uDisk['id'] or 0 }}">
                                    修改
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#deleteUDisk{{ $uDisk['id'] or 0 }}">
                                    删除
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @include('common.pagination', ['url' => url('/admin/u-disk/page') . '/', 'page' => $pagination['page'], 'count' => $pagination['count'], 'type' => 'search', ])
        {!! Form::close() !!}
        <div class="modal fade" id="createUDisk" tabindex="-1" role="dialog" aria-labelledby="createUDiskTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                @include('admin.u_disk.create')
            </div>
        </div>
        @foreach($uDiskList as $uDisk)
            <div class="modal fade" id="editUDisk{{ $uDisk['id'] or 0 }}" tabindex="-1" role="dialog" aria-labelledby="editUDisk{{ $uDisk['id'] or 0 }}Title" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    @include('admin.u_disk.edit')
                </div>
            </div>
            <div class="modal fade" id="deleteUDisk{{ $uDisk['id'] or 0 }}" tabindex="-1" role="dialog" aria-labelledby="deleteUDisk{{ $uDisk['id'] or 0 }}Title" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    @include('admin.u_disk.delete')
                </div>
            </div>
        @endforeach
    </div>
@endsection
