<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: Permission.php
 * Author  : Li Tao
 * DateTime: 2018-02-05 09:01:00
 */

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Zizaco\Entrust\EntrustPermission;

/**
 * entrust 插件库的 权限对象
 * Class Permission
 * @package App\Models
 */
class Permission extends EntrustPermission
{
    protected $fillable = [
        'name',
        'display_name',
        'description',
    ];

    public static function userHasPermission($userId, $permission = '')
    {
        $count = (new Permission)->leftJoin('permission_role', 'permissions.id', '=', 'permission_role.permission_id')
            ->leftJoin('role_user', 'permission_role.role_id', '=', 'role_user.role_id')
            ->where('role_user.user_id', '=', $userId)
            ->where('permissions.name', '=', $permission)
            ->count();
        return $count > 0 ? true : false;
    }

    public static function listPermission($page, $size)
    {
        $db = (new Permission);
        $count = $db->count();
        $permissionList = $db->forPage($page, $size)
            ->get();
        $data = [];
        $data['count'] = $count;
        $data['permissionList'] = $permissionList;
        return $data;
    }

    public static function searchPermission($search = [], $page, $size)
    {
        $db = (new Permission)->where(function ($query) use ($search) {
            if (isset($search) && isset($search['name']) && !empty($search['name'])) {
                $query->where('permissions.name', 'like', $search['name'])
                    ->orWhere('permissions.display_name', 'like', $search['name']);
            }
        });
        $count = $db->count();
        $permissionList = $db->forPage($page, $size)
            ->get();
        $data = [];
        $data['count'] = $count;
        $data['permissionList'] = $permissionList;
        return $data;
    }
}