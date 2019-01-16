<?php
namespace app\common\model;
class User extends \think\Model
{
    /**
     * 用户登录
     * @param  string $username 用户名
     * @param  string $password 密码
     * @return bool  成功返回true，失败返回false。
     */
    static public function login($username, $password)
    {
        // 验证用户是否存在
        $map = array('username' => $username);
        $User = self::get($map);
        
        if (!is_null($User)) {
            // 验证密码是否正确
            if ($User->checkPassword($password)) {
                // 登录
                session('userId', $User->getData('id'));
                return true;
            }
        }
        return false;
    }
    /**
     * 验证密码是否正确
     * @param  string $password 密码
     * @return bool           
     */
    public function checkPassword($password)
    {
        if($this->getData('password') === $this::encryptPassword($password)){
            return true;
        }
        else{
            return false;
        }
    }
    // 密码加密功能
    static public function encryptPassword($password)
    {   
        if(!is_string($password)){
            throw new \RuntimeException("传入的密码非字符串", 2);
        }
        // 还可以借助其它字符串算法，来实现不同的加密。
        return sha1(md5($password) . 'mengyunzhi');
        
    }
    static public function logOut()
    {
        // 销毁session中数据
        session('userId', null);
        return true;
    }
}