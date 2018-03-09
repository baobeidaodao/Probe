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
        {!! Form::open(['id' => 'searchForm', 'method'=> 'POST', 'url' => 'admin/ip/search']) !!}
        <div class="card-header">
            @include('admin.ip.search')
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">起始IP</th>
                        <th scope="col">结束IP</th>
                        <th scope="col">运营商</th>
                        <th scope="col">省</th>
                        <th scope="col">
                            @permission('create_ip')
                            <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#create">
                                创建
                            </button>
                            @endpermission
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($ipList as $ip)
                        <tr>
                            <th scope="row">{{ $ip['id'] or 0 }}</th>
                            <td>{{ $ip['start_ip'] or '' }}</td>
                            <td>{{ $ip['end_ip'] or '' }}</td>
                            <td>{{ $ip['operator_name'] or '' }}</td>
                            <td>{{ $ip['area_name'] or '' }}</td>
                            <td>
                                @permission('edit_ip')
                                <button type="button" class="btn btn-outline-warning btn-sm" data-toggle="modal" data-target="#edit{{ $ip['id'] or 0 }}">
                                    修改
                                </button>
                                @permission('delete_ip')
                                @endpermission
                                <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#delete{{ $ip['id'] or 0 }}">
                                    删除
                                </button>
                                @endpermission
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @include('common.pagination', ['url' => url('/admin/ip/page') . '/', 'page' => $pagination['page'], 'count' => $pagination['count'], 'type' => 'search', ])
        {!! Form::close() !!}
        <div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="createTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                @include('admin.ip.create')
            </div>
        </div>
        @foreach($ipList as $ip)
            <div class="modal fade" id="edit{{ $ip['id'] or 0 }}" tabindex="-1" role="dialog" aria-labelledby="edit{{ $ip['id'] or 0 }}Title" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    @include('admin.ip.edit')
                </div>
            </div>
            <div class="modal fade" id="delete{{ $ip['id'] or 0 }}" tabindex="-1" role="dialog" aria-labelledby="delete{{ $ip['id'] or 0 }}Title" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    @include('admin.ip.delete')
                </div>
            </div>
        @endforeach
    </div>
@endsection

