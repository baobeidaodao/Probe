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
        $data = [];
        $data['active'] = 'admin';
        return view('admin.index', $data);
    }
}