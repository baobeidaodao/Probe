<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: Role.php
 * Author  : Li Tao
 * DateTime: 2018-02-05 09:00:00
 */

namespace App\Models;

use Zizaco\Entrust\EntrustRole;

/**
 * entrust 插件库的 角色对象
 * Class Role
 * @package App\Models
 */
class Role extends EntrustRole
{
    protected $fillable = [
        'name',
        'display_name',
        'description',
    ];
}