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
use app\index\model\Home;
use think\model\Collection;

/**
 * 
 */
class HomeController extends Controller
{
    // 获取数据库信息，并传到Ｖ层显示。
    public function index() {

        // 查询当前学期
        $term = Term::where('state',1)->find();
        // var_dump($term->id);
        
        // 获取当前学期的所有课程
        $courseId = Course::where('term_id',$term->id)->column('id');
        // var_dump($courseId);
        
        // 获取本周的课程
        $classTime = ClassTime::where(['course_id' => $courseId])->select();
        // var_dump($classTime);
        // var_dump(strtotime(date('Y-m-d')));
        // var_dump(strtotime($term[0]['start_time']));
        $week = intval((strtotime(date('Y-m-d')) - strtotime($term->start_time))/7/86400);
        // var_dump($week);
        $classTime = $classTime->where('week',$week);
        // var_dump($classTime);
        
        $studentName = Student::where('state',1)->column('name'); 

        // var_dump($studentName);
        

        for ($j=0; $j < 7; $j++) { 
            for ($i=0; $i < 5; $i++) {

                $num = count($studentName);
                // var_dump($studentName[0]);
                for ($k=0; $k < $num; $k++) { 
                        $home = new Home;
                        $home->day = $j+1;
                        $home->period = $i+1;
                        $home->name = $studentName[$k];
                        $home->state = 0;
                        
                    if (!is_null($classTime)) {

                        $classTime = $classTime->where('day',$j+1);
                        $classTime = $classTime->where('period',$i+1);
                        // var_dump($classTime);
                         
                        // 获取学生Id
                        $stuCoursId = StudentCourses::where(['courses_id' => $classTime->column('course_id')])->column('student_id');

                        $stuState = Student::where(['id' => $stuCoursId])->column('state');
                            // var_dump($home);
                            // var_dump($stuState[0]);
                            if (!is_null($stuCoursId) && in_array(1, $stuState)) {
                                $stuName = Student::where(['id' => $stuCoursId],['state',1])->column('name');
                                // var_dump($stuName);
                                // $home->save();
                                if (!is_null($home->where(['name' => $stuName])->find())) {
                                    $home->where(['name' => $stuName])->find()->state = 1;
                                }
                                
                            }

                    }

                    $lists[$j][$i][$k] = $home;

                }
                // var_dump($home);

            }
            
           // var_dump($home);
        }
        $week = ['周一','周二','周三','周四','周五','周六','周日'];
        var_dump($lists[0][0][0]);
        // var_dump($list);
        $this->assign('week',$week);
        $this->assign('lists',$lists);
        return $this->fetch();
    }
}