<?php
namespace app\index\controller;
use think\Controller;

class Index extends Controller
{
    public function index()
    {
        $indexPage = $this->paginate(5);
        $indexPage->render();
        return $this->fetch();
    }
}
