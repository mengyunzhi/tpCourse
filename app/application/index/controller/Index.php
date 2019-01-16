<?php
namespace app\index\controller;
use think\Controller;

class Index extends PassController
{
    public function index()
    {
        $course       = Db::table('course')->limit(0,9999)->column('name','id');

        $term         = Db::table('term')->where('state',1)->column('name','id');

        $starttime    = Db::table('term')->where('state',1)->value('start_time');        //起始时间查询
        
        $endtime      = Db::table('term')->where('state',1)->value('end_time');          //结束时间查询
        
        $start_time   = strtotime($starttime);
        
        $end_time     = strtotime($endtime);
        
        $day          = ($end_time - $start_time) / 86400;
        
        $weeks        = $day / 7;  
        
        $nowweek      = ((strtotime('today') - strtotime($starttime)) / 86400) /7;

        $today        = date("y-m-d",time());

        $student      = Db::table('student')->limit(99)->value('name');

        $studentcourse      = Db::table('student_courses')->limit(99)->select();
        
        return $this->fetch();
    }
}
