<?php
/**
 * Created by PhpStorm.
 * User: lumin
 * Date: 17/7/6
 * Time: 上午10:20
 */

namespace App\Common;


class Utils
{
    public static function is_assoc($array)
    {
        if(is_array($array)) {
            $keys = array_keys($array);
            return $keys != array_keys($keys);
        }
        return false;
    }
}