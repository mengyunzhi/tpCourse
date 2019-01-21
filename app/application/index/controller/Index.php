<?php
namespace app\index\controller;
use think\Controller;

class Index extends PassController
{
    public function index()
    {
        $weeks = ['一'，'二'，'三'，'四'，'五'，'六'，'七'，];
        var_dump($weeks);
        return $this->fetch();
    }
}
