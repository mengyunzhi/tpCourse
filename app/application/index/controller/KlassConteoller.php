<?php
namespace app\index\controller;

use think\Facade\Request;
use think\Controller;
use think\Db;

class klass extends Controller
{
    public function index()
    {
        $klass = Request::instance()->get('course_id');
        var_dump($klass);
    }
}