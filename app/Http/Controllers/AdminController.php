<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: AdminController.php
 * Author  : Li Tao
 * DateTime: 2018-02-06 11:03:00
 */

namespace App\Http\Controllers;


class AdminController extends Controller
{
    public static function index()
    {
        return view('admin.index');
    }
}