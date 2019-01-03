<?php
namespace app\index\controller;
use think\Db;
use think\Request;
use think\Controller;

class IndexController extends Controller
{
    public function index()
    {
        return $this->fetch();
    }
}