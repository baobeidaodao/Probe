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
                        <th scope="col">Id</th>
                        <th scope="col">IP</th>
                        <th scope="col">UUID</th>
                        <th scope="col">Province</th>
                        <th scope="col">City</th>
                        <th scope="col">Operator</th>
                        <th scope="col">User Name</th>
                        <th scope="col">User Phone</th>
                        <th scope="col">Report Count</th>
                        <th scope="col">Date</th>
                        <th scope="col">View</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($reportList as $report)
                        <tr>
                            <th scope="row">{{ $report['report_id'] or 0 }}</th>
                            <td>{{ $report['ip'] or '' }}</td>
                            <td>{{ $report['uuid'] or '' }}</td>
                            <td>{{ $report['province'] or '' }}</td>
                            <td>{{ $report['city'] or '' }}</td>
                            <td>{{ $report['operator'] or '' }}</td>
                            <td>{{ $report['user_name'] or '' }}</td>
                            <td>{{ $report['user_phone'] or '' }}</td>
                            <td>{{ $report['report_count'] or '' }}</td>
                            <td>{{ $report['date'] or '' }}</td>
                            <td>
                                <button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#view{{ $report['report_id'] or 0 }}">
                                    View
                                </button>
                                <div class="modal fade" id="view{{ $report['report_id'] or 0 }}" tabindex="-1" role="dialog" aria-labelledby="view{{ $report['report_id'] or 0 }}Title" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        @include('admin.report.view')
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @include('common.pagination', ['url' => url('/admin/report/page') . '/', 'page' => $pagination['page'], 'count' => $pagination['count'], 'type' => 'search', ])
    </div>
    <input id="searchFormPage" type="hidden" name="page" value="{{ $pagination['page'] or 1 }}">
    {!! Form::close() !!}
@endsection
