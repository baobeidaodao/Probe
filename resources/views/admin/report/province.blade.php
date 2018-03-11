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
    {!! Form::open(['id' => 'searchForm', 'method' => 'POST', 'url' => 'admin/report/province']) !!}
    <div class="card">
        <div class="card-header">
            @include('admin.report.search')
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col">IP</th>
                        <th scope="col">所属省</th>
                        <th scope="col">所属运营商</th>
                        <th scope="col">测试时间</th>
                        <th scope="col">U盾省</th>
                        <th scope="col">U盾市</th>
                        <th scope="col">U盾运营商</th>
                        <th scope="col">类型</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($reportList as $report)
                        @foreach($report['report_list'] as $item)
                            <tr>
                                <td>{{ $item['ip'] or '' }}</td>
                                <td>{{ $item['report_province'] or '' }}</td>
                                <td>{{ $item['report_operator'] or '' }}</td>
                                <td>{{ $item['report_date'] or '' }}</td>
                                <td>{{ $item['province'] or '' }}</td>
                                <td>{{ $item['city'] or '' }}</td>
                                <td>{{ $item['operator'] or '' }}</td>
                                <td>@if($item['probe_type'] == 1) 自有 @else 公有 @endif</td>
                            </tr>
                        @endforeach
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
