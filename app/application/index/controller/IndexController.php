<?php
namespace app\index\controller;
use think\Db;
use think\facade\Request;
use think\Controller;
use app\common\model\StudentWeekPeriod;
use app\index\model\Student;
use app\index\model\Week;

class IndexController extends PassController
{
    public function index()
    {
       
        $weeks = Week::getWeeks();
       
        $this->assign('weeks', $weeks);
        $students = Db::table('Student')->field('name')->limit(20)->select();
        $this->assign('students', $students);
        return $this->fetch();
    }


}