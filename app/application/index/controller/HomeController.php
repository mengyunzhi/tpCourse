<?php 
namespace app\index\controller;
use app\index\model\Index;
use app\index\model\Student;
use think\Controller;
use think\Request;
use think\Db;

/**
 * 
 */
class HomeController extends PassController
{
    // 获取数据库信息，并传到Ｖ层显示。
    public function index() {

        // 验证用户是否登录
        $userId = session('userId');
        if ($userId === null)
        {
            return $this->error('请先登录', url('login/index'));
        }


        $stu = Db::name('student')->select();
        $this->assign('stu',$stu);

        return $this->fetch();
    }
}