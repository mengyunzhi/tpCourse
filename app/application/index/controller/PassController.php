<?php
namespace app\index\controller;
use think\Controller;
use app\common\model\User;
class PassController extends Controller
{
    public function __construct()
    {
        // 调用父类构造函数(必须)
        parent::__construct();

        // 验证用户是否登陆
        $userId = session('userId');
        if ($userId === null)
        {
            return $this->error('请先登录', url('login/index'));
        }
    }

    public function index()
    {
    }
}