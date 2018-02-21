<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: TestController.php
 * Author  : Li Tao
 * DateTime: 2018-02-11 04:35:00
 */

namespace App\Http\Controllers;

use App\Services\AdminService;
use App\Services\UDiskService;

class TestController extends Controller
{
    public static function index()
    {
        //AdminService::listAreaMap();
        UDiskService::listUDisk();
        return view('test');
    }
}