<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: AppService.php
 * Author  : Li Tao
 * DateTime: 2018-02-12 07:34:00
 */

namespace App\Services;

class AppService
{
    public static function arrayToObject($array)
    {
        if (is_array($array)) {
            $object = new \StdClass();
            foreach ($array as $key => $val) {
                $object->$key = $val;
            }
        } else {
            $object = $array;
        }
        return $object;
    }

    public static function objectToArray($object)
    {
        if (is_object($object)) {
            $array = array();
            foreach ($object as $key => $value) {
                $array[$key] = $value;
            }
        } else {
            $array = (array)$object;
        }
        return $array;
    }

    public static function calculatePagination($page, $size, $total)
    {
        $count = ceil($total / $size);
        $pagination = [];
        $pagination['page'] = intval($page) > intval($count) ? intval($count) : intval($page);
        $pagination['size'] = intval($size);
        $pagination['count'] = intval($count);
        $pagination['total'] = intval($total);
        return $pagination;
    }

    public static function ipToLong($ip)
    {
        //list($a, $b, $c, $d) = split(".", $ip);
        $array = explode('.', $ip);
        //return (($a * 256 + $b) * 256 + $c) * 256 + $d;
        return (($array[0] * 256 + $array[1]) * 256 + $array[2]) * 256 + $array[3];
    }
}