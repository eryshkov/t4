<?php

namespace T4\Orm\Extensions;

use T4\Orm\Exception;
use T4\Orm\Extension;

class Standard
    extends Extension
{

    public function callStatic($class, $method, $argv)
    {
        switch (true) {
            case preg_match('~^findAllBy(.+)$~', $method, $m):
                return $class::findAllByColumn($m[1], $argv[0]);
                break;
            case preg_match('~^findBy(.+)$~', $method, $m):
                return $class::findByColumn($m[1], $argv[0]);
                break;
        }
        throw new Exception('Method ' . $method . ' is not found in extension ' . __CLASS__);
    }

    public function call(&$model, $method, $argv)
    {
        switch (true) {
            case preg_match('~^set(.+)$~', $method, $m):
                $column = lcfirst($m[1]);
                $model->{$column} = $argv[0];
                return $model;
                break;
        }
        throw new Exception('Method ' . $method . ' is not found in extension ' . __CLASS__);
    }

}