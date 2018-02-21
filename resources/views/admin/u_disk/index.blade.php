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
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="thead-light">
            <tr>
                <th scope="col">id</th>
                <th scope="col">uuid</th>
                <th scope="col">user_name</th>
                <th scope="col">operator_name</th>
                <th scope="col">
                    <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#createUDisk">
                        Create
                    </button>
                    <div class="modal fade" id="createUDisk" tabindex="-1" role="dialog" aria-labelledby="createUDiskTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            @include('admin.u_disk.create')
                        </div>
                    </div>
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
                            Edit
                        </button>
                        <div class="modal fade" id="editUDisk{{ $uDisk['id'] or 0 }}" tabindex="-1" role="dialog" aria-labelledby="editUDisk{{ $uDisk['id'] or 0 }}Title" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                @include('admin.u_disk.edit')
                            </div>
                        </div>
                        <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#deleteUDisk{{ $uDisk['id'] or 0 }}">
                            Delete
                        </button>
                        <div class="modal fade" id="deleteUDisk{{ $uDisk['id'] or 0 }}" tabindex="-1" role="dialog" aria-labelledby="deleteUDisk{{ $uDisk['id'] or 0 }}Title" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                @include('admin.u_disk.delete')
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @include('common.pagination', ['url' => url('/admin/u-disk/') . '/', 'page' => $pagination['page'], 'count' => $pagination['count'],])
@endsection
