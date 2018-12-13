<?php
namespace app\index\controller;
use app\common\model\Course;
use think\Controller;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::paginate(3);

        $this->assign('courses', $courses);

        return $this->fetch();
    }

    public function add()
    {

    }
}