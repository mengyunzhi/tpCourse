<?php 
namespace app\index\controller;
use app\index\model\Index;
use app\index\model\Student;
use think\Controller;
use think\Request;
use think\Db;
use app\common\model\Term;
use app\index\model\ClassTime;
use app\common\model\Course;
use app\index\model\StudentCourses;

/**
 * 
 */
class HomeController extends Controller
{
    // 获取数据库信息，并传到Ｖ层显示。
    public function index() {

        // 查询当前学期
        $term = Term::where('state',1)->select();
        // var_dump($term[0]['id']);
        
        // 获取当前学期的所有课程
        $course = Course::where('term_id',$term[0]['id'])->select();
        // var_dump($course);
        
        // 获取本周的课程
        $classTime = ClassTime::where('course_id',$course[0]['id'])->select();
        // var_dump(strtotime(date('Y-m-d')));
        // var_dump(strtotime($term[0]['start_time']));
        $week = intval((strtotime(date('Y-m-d')) - strtotime($term[0]['start_time']))/7/86400);
        // var_dump($week);
        $classTime = $classTime->where('week',$week);
        // var_dump($classTime);


        for ($j=1; $j < 2; $j++) { 
            for ($i=1; $i < 2; $i++) { 
                $classTime = $classTime->where('day',$j);
                $classTime = $classTime->where('period',$i);
                var_dump($classTime[0]['course_id']);

                $stuCours = StudentCourses::where('courses_id',$classTime[0]['course_id'])->select();
                // 查询到有课的学生id
                var_dump($stuCours[0]['student_id']);
            }
            
        }
        $stu = Db::name('student')->where('state',1)->select();

        $this->assign('stu',$stu);

        return $this->fetch();
    }
}