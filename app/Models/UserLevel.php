<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: UserLevel.php
 * Author  : Li Tao
 * DateTime: 2018-02-22 15:21:00
 */

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Model;

class UserLevel extends Model
{
    protected $connection = 'mysql';
    protected $table = 'user_level';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $dates = ['deleted_at'];

    const LEVEL_ADMIN = 1;
    const LEVEL_GROUP_MANAGER = 2;
    const LEVEL_PROVINCIAL_MANAGER = 3;
    const LEVEL_MUNICIPAL_MANAGER = 4;
    const LEVEL_TESTER = 5;

    public static function listLevelForUser($user = null)
    {
        if (!isset($user)) {
            $user = Auth::user();
        }
        $level = isset($user->level) ? $user->level : self::LEVEL_ADMIN;
        $userLevelList = (new UserLevel)->where('id', '>=', $level)
            ->get()
            ->toArray();
        return $userLevelList;
    }
}