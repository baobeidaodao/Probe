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
        {!! Form::open(['id' => 'searchForm', 'method'=> 'POST', 'url' => 'admin/logs/search']) !!}
        <div class="card-header">
            @include('admin.logs.search')
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">人员</th>
                        <th scope="col">操作</th>
                        <th scope="col">备注</th>
                        <th scope="col">时间</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($actionLogList as $actionLog)
                        <tr>
                            <th scope="row">{{ $actionLog['id'] or 0 }}</th>
                            <td>{{ $actionLog['name'] or '' }}</td>
                            <td>{{ $actionLog['action_name'] or '' }}</td>
                            <td>{{ $actionLog['remark'] or '' }}</td>
                            <td>{{ $actionLog['created_at'] or '' }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @include('common.pagination', ['url' => url('/admin/logs/page') . '/', 'page' => $pagination['page'], 'count' => $pagination['count'], 'type' => 'search', ])
        {!! Form::close() !!}
    </div>
@endsection
