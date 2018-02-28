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
    {!! Form::open(['id' => 'searchForm', 'method' => 'POST', 'url' => 'admin/statistics/search']) !!}
    <div class="card">
        <div class="card-header">
            @include('admin.statistics.search')
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col">Id</th>
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
                    @foreach($statisticsList as $statistics)
                        <tr class=" @if(!isset($statistics['report_count']) || empty($statistics['report_count'])) table-danger @endif ">
                            <th scope="row">{{ $statistics['id'] or 0 }}</th>
                            <td>{{ $statistics['uuid'] or '' }}</td>
                            <td>{{ $statistics['province'] or '' }}</td>
                            <td>{{ $statistics['city'] or '' }}</td>
                            <td>{{ $statistics['operator'] or '' }}</td>
                            <td>{{ $statistics['user_name'] or '' }}</td>
                            <td>{{ $statistics['user_phone'] or '' }}</td>
                            <td>{{ $statistics['report_count'] or '' }}</td>
                            <td>{{ $statistics['date'] or '' }}</td>
                            <td>
                                <button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#view{{ $statistics['id'] or 0 }}">
                                    View
                                </button>
                                <div class="modal fade" id="view{{ $statistics['id'] or 0 }}" tabindex="-1" role="dialog" aria-labelledby="view{{ $statistics['id'] or 0 }}Title" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        @include('admin.statistics.view')
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @if(isset($search) && isset($search['province_id']) && !empty($search['province_id']))
                @include('admin.statistics.tips')
            @endif
        </div>
        @include('common.pagination', ['url' => url('/admin/statistics/page') . '/', 'page' => $pagination['page'], 'count' => $pagination['count'], 'type' => 'search', ])
    </div>
    <input id="searchFormPage" type="hidden" name="page" value="{{ $pagination['page'] or 1 }}">
    {!! Form::close() !!}
@endsection
