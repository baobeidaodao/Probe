<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: Area.php
 * Author  : Li Tao
 * DateTime: 2018-02-21 11:59:00
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $connection = 'mysql';
    protected $table = 'area';
    protected $primaryKey = 'id';
    public $timestamps = false;

}