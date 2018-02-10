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
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0 text-center" href="{{ url('/') }}">{{ config('app.name', 'Laravel') }}</a>
        <!-- <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search"> -->
        <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hide">
                    {{ csrf_field() }}
                </form>
            </li>
        </ul>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        @role('admin')
                        @endrole
                        <li class="nav-item">
                            <a class="nav-link @if(isset($active) && $active === 'admin') active @endif " href="{{ url('/admin') }}">
                                <h4>Admin</h4>
                                <span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(isset($active) && $active === 'roles') active @endif " href="{{ url('admin/roles') }}">
                                <h5>角色管理</h5>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(isset($active) && $active === 'permissions') active @endif " href="{{ url('admin/permissions') }}">
                                <h5>权限管理</h5>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(isset($active) && $active === 'users') active @endif " href="{{ url('admin/users') }}">
                                <h5>用户管理</h5>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
                @section('main')
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                        <h1 class="h2">Dashboard</h1>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <div class="btn-group mr-2">
                                <button class="btn btn-sm btn-outline-secondary">Export</button>
                            </div>
                        </div>
                    </div>
                @show
            </main>
        </div>
    </div>
@endsection
