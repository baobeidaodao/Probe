<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: header.blade.php
 * Author  : Li Tao
 * DateTime: 2018-02-06 19:30:00
 */
?>

<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0 text-center" href="{{ url('/') }}">{{ config('app.name', 'Laravel') }}</a>
    <!-- <input class="form-control form-control-dark w-100" type="text" placeholder="搜索" aria-label="Search"> -->
    <ul class="navbar-nav navbar-nav flex-row ml-md-auto d-none d-md-flex">
        @if (Auth::guest())
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">登陆</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">注册</a>
            </li>
        @else
            <li class="nav-item text-nowrap">
                <a class="nav-link" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ Auth::user()->name }}
                </a>
            </li>
            <li class="nav-item text-nowrap">
                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">退出</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hide">
                    {{ csrf_field() }}
                </form>
            </li>
        @endif
    </ul>
</header>
