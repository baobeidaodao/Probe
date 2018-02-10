<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: AdminService.php
 * Author  : Li Tao
 * DateTime: 2018-02-11 01:47:00
 */

namespace App\Services;

use App\Models\Role;
use App\Models\User;

class AdminService
{
    public static function isAdmin($user, $role)
    {
        if (User::isAdmin($user) && Role::isAdmin($role)) {
            return true;
        } else {
            return false;
        }
    }
}