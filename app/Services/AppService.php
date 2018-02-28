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
}