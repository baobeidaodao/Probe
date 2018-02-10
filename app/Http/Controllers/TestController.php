<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: TestController.php
 * Author  : Li Tao
 * DateTime: 2018-02-11 04:35:00
 */

namespace App\Http\Controllers;

class TestController extends Controller
{
    public static function index()
    {
        return view('test');
    }
}