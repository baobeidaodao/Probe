<?php

namespace App\Models;

use Auth;
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
        'name', 'email', 'password', 'phone', 'level', 'department_id', 'area_id', 'province_id', 'city_id',
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
        $user = Auth::user();
        $db = User::with('roles.perms')
            ->where(function ($query) {
                //$area = Area::areaForUser();dd($area);
                //$query->whereIn('users.area_id', $area['areaIdList']);
            })
            ->where(function ($query) {
                $query->where('users.level', '>', Auth::user()->level);
                $query->orWhere('users.id', '=', Auth::id());
            })
            ->where(function ($query) use ($search, $user) {
                if (isset($search) && isset($search['name']) && !empty($search['name'])) {
                    $query->where('users.name', 'like', $search['name']);
                }
                if (isset($search) && isset($search['area_id']) && !empty($search['area_id'])) {
                    $query->where('users.area_id', '=', $search['area_id']);
                }
                if (isset($user->level) && $user->level > UserLevel::LEVEL_GROUP_MANAGER) {
                    if ($user->level == UserLevel::LEVEL_PROVINCIAL_MANAGER) {
                        $query->where('users.level', '>', $user->level);
                        $query->where('users.province_id', '=', $user->province_id);
                    }
                    if ($user->level == UserLevel::LEVEL_MUNICIPAL_MANAGER) {
                        $query->where('users.level', '>', $user->level);
                        $query->where('users.city_id', '=', $user->city_id);
                    }
                    $query->orWhere('users.id', '=', Auth::id());
                }
                if (isset($search) && isset($search['department_id']) && !empty($search['department_id'])) {
                    $query->where('users.department_id', '=', $search['department_id']);
                }
            })
            ->orderBy('users.level', 'asc')
            ->orderBy('users.area_id', 'asc')
            ->orderBy('users.id', 'asc');
        $count = $db->count();
        $userList = $db->forPage($page, $size)
            ->get();
        $data = [];
        $data['count'] = $count;
        $data['userList'] = $userList;
        return $data;
    }

    public static function listUserForAuth()
    {
        $user = Auth::user();
        $userList = (new User)
            ->where(function ($query) use ($user) {
                if (isset($user->level) && $user->level > UserLevel::LEVEL_GROUP_MANAGER) {
                    if ($user->level == UserLevel::LEVEL_PROVINCIAL_MANAGER) {
                        $query->where('users.level', '>', $user->level);
                        $query->where('users.province_id', '=', $user->province_id);
                    }
                    if ($user->level == UserLevel::LEVEL_MUNICIPAL_MANAGER) {
                        $query->where('users.level', '>', $user->level);
                        $query->where('users.city_id', '=', $user->city_id);
                    }
                    $query->orWhere('users.id', '=', Auth::id());
                }
            })
            ->get()
            ->toArray();
        return $userList;
    }

    public static function listUserIdForAuth()
    {
        $userIdList = [];
        $userList = self::listUserForAuth();
        foreach ($userList as $user) {
            $userIdList[] = $user['id'];
        }
        return $userIdList;
    }

    public static function listUserForCity($cityId, $userLevel = UserLevel::LEVEL_TESTER)
    {
        $userList = (new User)
            ->where('users.city_id', '=', $cityId)
            ->where('users.level', '=', $userLevel)
            ->get()
            ->toArray();
        return $userList;
    }
}
