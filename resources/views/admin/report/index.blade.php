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
    {!! Form::open(['id' => 'searchForm', 'method' => 'POST', 'url' => 'admin/report/search']) !!}
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
                        {{--<th scope="col">UUID</th>--}}
                        <th scope="col">省</th>
                        <th scope="col">市</th>
                        <th scope="col">运营商</th>
                        <th scope="col">上报省</th>
                        <th scope="col">上报运营商</th>
                        <th scope="col">上报类型</th>
                        <th scope="col">时间</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($reportList as $report)
                        <tr class=" @if(!isset($report['report_count']) || empty($report['report_count'])) table-danger @endif ">
                            <td>{{ $report['ip'] or '' }}</td>
                            {{--<td>{{ $report['uuid'] or '' }}</td>--}}
                            <td>{{ $report['province'] or '' }}</td>
                            <td>{{ $report['city'] or '' }}</td>
                            <td>{{ $report['operator'] or '' }}</td>
                            <td>{{ $report['report_province'] or '' }}</td>
                            <td>{{ $report['report_operator'] or '' }}</td>
                            <td> @if($report['probe_type'] == 1) 自有 @else 公有 @endif </td>
                            <td>{{ $report['report_date'] or '' }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @if(isset($search) && isset($search['province_id']) && !empty($search['province_id']))
                @include('admin.statistics.tips')
            @endif
        </div>
        @include('common.pagination', ['url' => url('/admin/report/page') . '/', 'page' => $pagination['page'], 'count' => $pagination['count'], 'type' => 'search', ])
    </div>
    {!! Form::close() !!}
@endsection
