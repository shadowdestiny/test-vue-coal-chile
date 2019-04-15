<?php
/**
 * Created by PhpStorm.
 * User: lmarin
 * Date: 14/4/2019
 * Time: 4:52 PM
 */

namespace App;


class Vue
{
    public static function prop($name, $value)
    {
        return sprintf(":%s='%s'", $name, json_encode($value));
    }
}