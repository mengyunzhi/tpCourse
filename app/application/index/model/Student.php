<?php 
namespace app\index\model;
use app\index\model\ContributionRecord;
use think\Model;
use think\model\Collection;
use app\index\model\StudentCourses;

/**
 * 
 */
class Student extends Model
{
    public function getMonthTotal() {

        // get month begin time
        $time = strtotime('first day of this month');

        // get current time
        $contri = ContributionRecord::where('student_id',$this->id)->select();

        $nub = 0;

        $num = count($contri);

        // get sum
        for ($i = 0; $i < $num; $i ++) { 

            if (strtotime($contri[$i]['time']) - $time > 0) {

               $nub += $contri[$i]['contribution'];

            }
        }
        
        // return
        return $nub;
    }

    public function getWeekTotal() {

        $time = strtotime('monday this week');
        
        // get current time
        $contri = ContributionRecord::where('student_id',$this->id)->select();

        $nub = 0;

        $num = count($contri);

        // get sum
        for ($i=0; $i < $num; $i++) { 

            if (strtotime($contri[$i]['time']) - $time > 0) {

               $nub += $contri[$i]['contribution'];

            }
        }
        
        // return
        return $nub;
    }

    public function getHasCourse($studentId,$dayId,$periodId) {

        // 查询当前学期，找到开始时间
        $term = Term::where('state',1)->find();
        // 计算现在是第几周
        $week = intval((strtotime(date('Y-m-d')) - strtotime($term->start_time))/7/24/60/60)+1;
        // 查询本周的课程
        $courseId = ClassTime::where('day',$dayId)->where('period',$periodId)->where('week',$week)->column('course_id');
        // 查询当前学生在当前周次,节次是否有课。
        $count = count(StudentCourses::where(['courses_id'=>$courseId])->where('student_id',$studentId)->find());
        // 有课则大于0;
        if ($count > 0) {
            return 'true';
        } else {
            return 'faluse';
        }

    }
}