<?php
/**
 * Created by PhpStorm.
 * User: kewin.cheng
 * Date: 2017/11/4
 * Time: 10:42
 */

include("common/validate.php");

$validate = validate::get_instance();

var_dump($validate->isInt(2));
var_dump($validate->isRangeWithDefault(2,4,5));
var_dump($validate->isUrl("http://www"));
var_dump($validate->callback(""));

