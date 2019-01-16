
<?php
namespace app\index\controller;
use app\common\model\CourseTerm;
use think\facade\Request;
use think\Controller;
use think\Db;

class CourseTermController extends PassController
{
    public function index()
    {
        return $this->fetch();
    }

}