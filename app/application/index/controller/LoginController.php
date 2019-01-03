<?php
namespace app\index\controller;
use think\Controller;
use think\facade\Request;
use app\index\model\User; 
/**
 * 登录
 */
class LoginController extends Controller
{
    // 用户登录表单
    public function index()
    {
        // 显示登录表单
        return $this->fetch();;
    }

    // 处理用户提交的登录数据
    public function login()
    {
        // 接收post信息
        $postData = Request::post();
        
        // 直接调用M层方法，进行登录。
        if (User::login($postData['username'], $postData['password'])) {
            return $this->success('登陆成功', url('User/index'));
        } else {
            return $this->error('用户名或密码不正确', url('index'));
        }
    }
    // 注销功能
    public function logOut()
    {
        if (User::logOut()) {
            return $this->success('注销成功',url('index'));
        } else {
            return $this->error('注销失败',url('index'));
        }
    }
}