<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: UDiskService.php
 * Author  : Li Tao
 * DateTime: 2018-02-21 23:16:00
 */

namespace App\Services;

use App\Models\UDisk;

class UDiskService
{
    public static function listUDisk($page = 1, $size = 10)
    {
        $data = UDisk::listUDisk($page, $size);
        $data = AppService::objectToArray($data);
        $uDiskList = $data['uDiskList'];
        $pagination = AppService::calculatePagination($page, $size, $data['count']);
        $data['uDiskList'] = $uDiskList;
        $data['pagination'] = $pagination;
        return $data;
    }
}