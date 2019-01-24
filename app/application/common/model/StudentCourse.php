<?php
namespace app\common\Model;
use app\index\Model\StudentCourses;
use think\model\Collection;
use app\common\Model\ClassTime;
use think\Db;

/**
 * 学生课程
 */
class StudentCourse {
    function getHasCourseOrNot($studentId, $weekId, $periodId) {
       // 查询当前学期，找到开始时间
        $term       = Term::where('state',1)->find();
        // 计算现在是第几周
        $startweek  = Db::name('term')->where('state', 1)->value('start_time');
        
        $nowweek    = (strtotime('today') - strtotime($startweek)) / 604800;
        
        $intnowweek = (integer)$nowweek;
        
        // 查询本周的课程
        $courseId = ClassTime::where([
            ['day','in', $weekId],
           ['period','in',$periodId],
            ['week','in',$weekId],
        ])->column('course_id');
        // 根据：学生ID， 课程IDS -> 判断是否有课
        
        $courseId = Db::table('course')->column('id');
        
        $on = StudentCourses::where([
            ['student_id','in',$studentId],
            ['courses_id','in',$courseId]
        ])->select();
        
        $count = count($on);
        
         if ($count > 0) {
            return 'true';
        } else {
            return 'false';
        }
       
    }  

}