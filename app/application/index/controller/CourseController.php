<?php
namespace app\index\controller;

use app\common\model\Course;
use app\index\model\ClassTime;
use app\index\model\Term;
use think\Facade\Request;
use think\Controller;
use think\Db;

class CourseController extends Controller
{
   
    public function index()                                     //index界面
    {   
        
        $name         = Request::instance()->get('name');       //课程查询
        
        $coursepage   = Request::instance()->get('pageSize');   //分页

        $pageSize = 5;                                          //页数5条
        
        $Course       = new Course();
                                                                //定制查询条件倒序显示
        $courses      =$Course->where('name','like','%'.$name .'%')->order('id desc')->paginate($pageSize,false,[
            'query'=>[
            'name'=>$name,
            ],
        ]);

        $this->assign('courses', $courses);                     //将数据传给V层
        
        return $this->fetch();                                  //页面渲染
    }
    
    public function add()                                       //增加功能
    {
        
        return $this->fetch();                                  //页面渲染
    }
    
    public function save()                                      //add的保存事件
    {
        $Course       = new Course;                             // 实例化Course空对象
         
        $Course->name = Request::instance()->post('name');      // 为对象赋值
 
        if (false   === $Course->save()) {                      // 依据状态定制提示信息
            return $this->error('添加失败' . $Course->getError());
        }
        return $this->success('添加成功', url('index'));         // 成功进行跳转
    }
   
    public function delete()                                    //删除事件
    {
        $id           = Request::instance()->param('id/d');     // 获取pathinfo传入的ID值.

        $Course       = Course::get($id);                       // 获取要删除的对象

        if (!$Course->delete()) {                               // 删除对象
             return $this->error('删除失败:' . $Course->getError());
        }

        return $this->success('删除成功', url('index'));        // 成功进行跳转
     }
    
     public function edit()                                     //修改功能
    {
        $course       = Request::instance()->param('id/d');     // 获取传入ID
        
        if (is_null($course = course::get($course))) {          // 在Course表模型中获取当前记录
            return '系统未找到ID为' . $course . '的记录';
        } 
        
        $this->assign('course', $course);                       // 将数据传给V层

        return $this->fetch();                                  // 将封装好的V层内容返回给用户
    }
    
    public function update()                                    //修改更新事件
    {
        $id           = Request::instance()->post('id/d');      // 接收数据，获取要更新的关键字信息
        
        $Course       = Course::get($id);                       // 获取当前对象
        
        $Course->name = Request::instance()->post('name');      // 写入要更新的数据
        
        if (false === $Course->save()) {                        // 依据状态定制提示信息
            return $this->error('更新失败' . $Course->getError());
        }
        return $this->success('操作成功', url('index'));         // 成功进行跳转
    }
    
    public function inquiry(){
        
        return $this->fetch();
    }
    public function add_course()
    {
        $classtime       = new ClassTime;                             // 实例化Course空对象
        $data = [
           'day' => null,'period' => '','week' => ''
        ];
        // 分批写入 每次最多100条数据
        $classtime = Db::name('class_time')->data($data)->insertAll();      // 为对象赋值
        $this->assign('data',$data);

        
        return $this->fetch();
    }
    public function save_course()
    {
        $classtime = new ClassTime;
        
        $ct = Request::instance()->post();      // 为对象赋值
        
        
        var_dump($ct['day']);
        $classtime->day = $ct['day'];
        $classtime->period = $ct['period'];
        $classtime->week = $ct['week'];
       
        if (false   === $classtime->save()) {                      // 依据状态定制提示信息
            return $this->error('添加失败' . $classtime->getError());
        }
        return $this->success('添加成功', url('inquiry'));         // 成功进行跳转
    }
    
}