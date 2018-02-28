<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: index.blade.php
 * Author  : Li Tao
 * DateTime: 2018-02-06 11:58:00
 */
?>

@extends('html')

@section('body')
    @include('common.header')
    <div class="container-fluid">
        <div class="row">
            @include('common.navbar')
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
                @section('main')
                    @role('admin')
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                        <h1 class="h2">Dashboard</h1>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            更新数据报表
                        </div>
                        <div class="card-body">
                            @include('admin.update_statistics')
                        </div>
                    </div>
                    @endrole
                @show
            </main>
        </div>
    </div>
@endsection
