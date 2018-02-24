<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: index.blade.php
 * Author  : Li Tao
 * DateTime: 2018-02-23 08:48:00
 */
?>

@extends('admin.index')

@section('main')
    <div class="card">
        <div class="card-header">
            @include('admin.ip.search')
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">ip</th>
                        <th scope="col">mask</th>
                        <th scope="col">type</th>
                        <th scope="col">operator</th>
                        <th scope="col">province</th>
                        <th scope="col">
                            <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#createPermission">
                                Create
                            </button>
                            <div class="modal fade" id="createPermission" tabindex="-1" role="dialog" aria-labelledby="createPermissionTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    @include('admin.ip.create')
                                </div>
                            </div>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($ipList as $ip)
                        <tr>
                            <th scope="row">{{ $ip['id'] or 0 }}</th>
                            <td>{{ $ip['ip'] or '' }}</td>
                            <td>{{ $ip['mask'] or '' }}</td>
                            <td>{{ $ip['type'] or '' }}</td>
                            <td>{{ $ip['operator_name'] or '' }}</td>
                            <td>{{ $ip['area_name'] or '' }}</td>
                            <td>
                                <button type="button" class="btn btn-outline-warning btn-sm" data-toggle="modal" data-target="#edit{{ $ip['id'] or 0 }}">
                                    Edit
                                </button>
                                <div class="modal fade" id="edit{{ $ip['id'] or 0 }}" tabindex="-1" role="dialog" aria-labelledby="edit{{ $ip['id'] or 0 }}Title" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        @include('admin.ip.edit')
                                    </div>
                                </div>
                                <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#delete{{ $ip['id'] or 0 }}">
                                    Delete
                                </button>
                                <div class="modal fade" id="delete{{ $ip['id'] or 0 }}" tabindex="-1" role="dialog" aria-labelledby="delete{{ $ip['id'] or 0 }}Title" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        @include('admin.ip.delete')
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @include('common.pagination', ['url' => url('/admin/ip/page') . '/', 'page' => $pagination['page'], 'count' => $pagination['count'],])
    </div>
@endsection

