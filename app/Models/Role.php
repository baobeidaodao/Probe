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

    protected static $admin = 'admin'; // 默认的初始管理员用户

    /**
     * @return string
     */
    public static function getAdmin()
    {
        return self::$admin;
    }

    public static function isAdmin($role)
    {
        if (isset($role->name) && $role->name === self::$admin) {
            return true;
        } else {
            return false;
        }
    }

    public static function listRole($page, $size)
    {
        $db = Role::with('perms');
        $count = $db->count();
        $roleList = $db->forPage($page, $size)
            ->get();
        $data = [];
        $data['count'] = $count;
        $data['roleList'] = $roleList;
        return $data;
    }

    public static function searchRole($search = [], $page, $size)
    {
        $db = Role::with('perms')
            ->where(function ($query) use ($search) {
                if (isset($search) && isset($search['name']) && !empty($search['name'])) {
                    $query->where('roles.name', 'like', $search['name'])
                        ->orWhere('roles.display_name', 'like', $search['name']);
                }
            });
        $count = $db->count();
        $roleList = $db->forPage($page, $size)
            ->get();
        $data = [];
        $data['count'] = $count;
        $data['roleList'] = $roleList;
        return $data;
    }
}