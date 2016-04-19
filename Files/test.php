<?php
/**
 * Author: helen
 * CreateTime: 2016/4/19 19:10
 * description:
 */

class Transform{
    private $str;
    private $count;

    public function __construct($str,$count){
        $this->str 	  = $str;
        $this->count  = $count;
    }

    public function trans(){
        $arr = explode(' ',$this->str);
        $back_arr = array();
        //初级变换，大小写转换
        foreach($arr as $key=>$value){
            $count = strlen($value);
            $str = '';
            for($i=0;$i<$count;$i++){
                $tip = substr($value,$i,1);
                if($tip>='a'&&$tip<='z'){
                    $tip = strtoupper($tip);
                }else{
                    $tip = strtolower($tip);
                }
                $str .= $tip;
            }
            array_push($back_arr,$str);
        }
        //顺序转换
        $back_arr = array_reverse($back_arr);
        $back_arr = implode(' ',$back_arr);
        return $back_arr;
    }


}

//demo
$str = 'This is a sample';
$count = 16;;
$transform = new Transform($str,$count);
$trans = $transform->trans();
var_dump($trans);

