<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use SoftDeletes;

    use Notifiable;
    /**
     * 权限插件库 entrust
     * This will enable the relation with Role and add the following methods roles(), hasRole($name), withRole($name), can($permission), and ability($roles, $permissions, $options) within your User model.
     */
    use EntrustUserTrait {
        EntrustUserTrait::restore insteadof SoftDeletes; // 解决 trait 方法名冲突
    }

    /**
     * 需要被转换成日期的属性。
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'level', 'subjection', 'area_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected static $admin = 'admin@probe.com'; // 默认的初始管理员用户

    /**
     * @return string
     */
    public static function getAdmin()
    {
        return self::$admin;
    }

    public static function isAdmin($user)
    {
        if (isset($user->email) && $user->email === self::$admin) {
            return true;
        } else {
            return false;
        }
    }

    public static function listUser($page, $size)
    {
        $db = User::with('roles.perms');
        $count = $db->count();
        $userList = $db->forPage($page, $size)
            ->get();
        $data = [];
        $data['count'] = $count;
        $data['userList'] = $userList;
        return $data;
    }

    public static function searchUser($search = [], $page, $size)
    {
        $db = User::with('roles.perms')
            ->where(function ($query) use ($search) {
                if (isset($search) && isset($search['name']) && !empty($search['name'])) {
                    $query->where('users.name', 'like', $search['name']);
                }
                if (isset($search) && isset($search['area_id']) && !empty($search['area_id'])) {
                    $query->where('users.area_id', '=', $search['area_id']);
                }
            });
        $count = $db->count();
        $userList = $db->forPage($page, $size)
            ->get();
        $data = [];
        $data['count'] = $count;
        $data['userList'] = $userList;
        return $data;
    }

}
