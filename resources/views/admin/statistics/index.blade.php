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
    {!! Form::open(['id' => 'searchForm', 'method' => 'POST', 'url' => 'admin/statistics/' . $form, 'data-for' => $form, ]) !!}
    <div class="card">
        <div class="card-header">
            @include('admin.statistics.summary')
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-light">
                    <tr>
                        {{--<th scope="col">UUID</th>--}}
                        <th scope="col">省</th>
                        <th scope="col">市</th>
                        <th scope="col">运营商</th>
                        <th scope="col">人员</th>
                        <th scope="col">电话</th>
                        <th scope="col">上报数</th>
                        @if($form == 'search')
                            <th scope="col">日期</th>
                        @endif
                        <th scope="col">查看</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($statisticsList as $statistics)
                        <tr class=" @if(!isset($statistics['report_count']) || empty($statistics['report_count'])) table-danger @endif ">
                            {{--<td>{{ $statistics['uuid'] or '' }}</td>--}}
                            <td>{{ $statistics['province'] or '' }}</td>
                            <td>{{ $statistics['city'] or '' }}</td>
                            <td>{{ $statistics['operator'] or '' }}</td>
                            <td>{{ $statistics['user_name'] or '' }}</td>
                            <td>{{ $statistics['user_phone'] or '' }}</td>
                            <td>{{ $statistics['report_count'] or '' }}</td>
                            @if($form == 'search')
                                <td>{{ date('Y-m-d', strtotime($statistics['date'])) }}</td>
                            @endif
                            <td>
                                <button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#view{{ $statistics['id'] or 0 }}">
                                    查看
                                </button>
                                <div class="modal fade bd-example-modal-lg" id="view{{ $statistics['id'] or 0 }}" tabindex="-1" role="dialog" aria-labelledby="view{{ $statistics['id'] or 0 }}Title" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
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
    {!! Form::close() !!}
@endsection
