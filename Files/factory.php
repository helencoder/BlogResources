<?php
/**
 * Author: helen
 * CreateTime: 2016/4/21 11:31
 * description: 工厂模式
 */
abstract class ShareFactory{
    static function create($type , array $sizes){
        switch ($type){
            case 'rectangle':
                return new Rectangle($sizes[0],$sizes[1]);
                break;
            case 'triangle':
                return new Triangle($sizes[0],$sizes[1],$sizes[2]);
                break;
        }
    }
}