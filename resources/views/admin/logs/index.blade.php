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
                <th scope="col">User</th>
                <th scope="col">Action</th>
                <th scope="col">Remark</th>
                <th scope="col">Time</th>
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
    @include('common.pagination', ['url' => url('/admin/logs/') . '/', 'page' => $pagination['page'], 'count' => $pagination['count'],])
@endsection
