<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: header.blade.php
 * Author  : Li Tao
 * DateTime: 2018-02-06 19:30:00
 */
?>

<header class="navbar navbar-expand-sm navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <ul class="navbar-nav">
                <li class="nav-item @if(isset($active) && $active === 'home') active @endif ">
                    <a class="nav-link" href="{{ url('/home') }}">Home<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item @if(isset($active) && $active === 'admin') active @endif ">
                    <a class="nav-link" href="{{ url('/admin') }}">Admin</a>
                </li>
                @role('admin')
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="managePermission" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        用户权限管理
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="managePermission" role="menu">
                        <li>
                            <a class="dropdown-item" href="{{ url('admin/roles') }}" target="_self">
                                角色
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ url('admin/permissions') }}" target="_self">
                                权限
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ url('admin/users') }}" target="_self">
                                用户
                            </a>
                        </li>
                    </ul>
                </li>
                @endrole
            </ul>
            <ul class="navbar-nav navbar-nav flex-row ml-md-auto d-none d-md-flex">
                @if (Auth::guest())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink" role="menu">
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                            </li>
                        </ul>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</header>
