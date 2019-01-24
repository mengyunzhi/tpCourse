<?php

namespace app\index\model;

use think\Model;

class Week
{
   
    static public function getWeeks()
    {
        $weeks = [];
        $sever = ['一', '二', '三', '四', '五', '六', '日'];
        $periods = ['一', '二', '三','四','五'];
        
        for ($i = 0; $i < 7; $i++)  {
            $week = new Week();
            $week->name = $sever[$i];
            $week->periods = $periods;
            
            array_push($weeks, $week);
            
        }
        return $weeks;
    }
}