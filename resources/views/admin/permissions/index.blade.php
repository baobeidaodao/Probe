<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: index.blade.php
 * Author  : Li Tao
 * DateTime: 2018-02-07 07:34:00
 */
?>

@extends('html')

@section('body')
    @include('common.header')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-3">
                <div class="card">
                    <div class="card-header">
                        <h3>创建权限</h3>
                    </div>
                    <div class="card-body">
                        @include('admin.permissions.create')
                    </div>
                </div>
            </div>
            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-9">
                @include('admin.permissions.table')
            </div>
        </div>
    </div>
@endsection