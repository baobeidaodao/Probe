<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: ProbeResultVerified.php
 * Author  : Li Tao
 * DateTime: 2018-02-22 02:40:00
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProbeResultVerified extends Model
{
    protected $connection = 'mysql';
    protected $table = 'probeResultVerified';
    protected $primaryKey = 'id';
    public $timestamps = false;
}