<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: UserLevel.php
 * Author  : Li Tao
 * DateTime: 2018-02-22 15:21:00
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLevel extends Model
{
    protected $connection = 'mysql';
    protected $table = 'user_level';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
}