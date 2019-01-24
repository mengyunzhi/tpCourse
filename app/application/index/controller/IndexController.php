<?php
namespace app\index\controller;
use think\Db;
use think\facade\Request;
use think\Controller;
use app\common\model\StudentWeekPeriod;
use app\index\model\Student;
use app\index\model\Week;
use app\index\model\ClassTime;
use app\common\model\StudentCourse;

class IndexController extends PassController
{
    public function index()
    {
       
        $weeks = Week::getWeeks();
       
        $this->assign('weeks', $weeks);
        
        $students = Student::where('state',1)->select();
        
        $this->assign('students', $students);

        $periods   = Db::table('class_time')->field('id, week, period, day')->select();
        $this->assign('period', $periods);

        $studentCourse = new StudentCourse();
        $this->assign('studentCourse', $studentCourse);

        $startweek  = Db::name('term')->where('state', 1)->value('start_time');
        
        $nowweek    = (strtotime('today') - strtotime($startweek)) / 604800;
        
        $intnowweek = (integer)$nowweek;
        var_dump($intnowweek);
        $this->assign('intnowweeks', $intnowweek);

        //$count = $xxxx -> where('studentId' ,$studentId ) ->where('course_id', $courseIds)->count();
       
        
        return $this->fetch();
        
    }


}