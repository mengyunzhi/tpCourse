<?php
namespace app\index\controller;

use app\common\model\Course;
use app\index\model\ClassTime;
use app\index\model\Term;
use think\facade\Request;
use think\Validate;
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
 
        
        $rule = [
            'name'  => 'require|max:25',
        ];
       
        
        $msg = [
            'name.require' => '名称必须',
            'name.max'     => '名称最多不能超过25个字符',
            
        ];

        $data = [
            'name' => '',
        ];
        $validate   = Validate::make($rule,$msg);
        $result = $validate->check($data);

        

        if (false   === $Course->save()) {                      // 依据状态定制提示信息
            return $this->error('' . $validate->getError());
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
    
    public function inquiry()
    {
        
        $id       = Request::instance()->param('id/d');     // 获取传入ID
        
        $course       = Course::get($id);                       // 获取当前对象

        $this->assign('course',$course);
        return $this->fetch();
    }
    public function updateinquiry()
    {
        $id           = Request::instance()->post('id/d');      // 接收数据，获取要更新的关键字信息
        
        $course       = Course::get($id);                       // 获取当前对象
        
        $course->name = Request::instance()->post('name');      // 写入要更新的数据
        $this->fetch();    
    }
    public function add_course()
    {
        $classtime       = new ClassTime;                             // 实例化Course空对象
        $data = [
           'day' => '','period' => '','week' => '','course_id' => '',
        ];
        // 分批写入 每次最多100条数据
        $classtime = Db::name('class_time')->data($data)->insertAll();      // 为对象赋值
        $this->assign('data',$data);

        // 获取当前点击的学生id
        $classtime = ClassTime::get(Request::param('id/d'));

        // 将获取的数据传到V层
        $this->assign('classtime',$classtime);
        
        $id       = Request::instance()->param('id/d');     // 获取传入ID
        
        $course       = Course::get($id);                       // 获取当前对象

        $this->assign('course',$course);
        
        return $this->fetch();
    
    }
    public function save_course()
    {

        $classtime = new ClassTime;
        
        $ct = Request::instance()->post();      // 为对象赋值
        
        //预先定义一下才可以
        
        $classtime->day = $ct['day'];
        $classtime->period = $ct['period'];
        $classtime->week = $ct['week'];
        $classtime->course_id = $ct['course_id'];
        
        $rule = [
            'day'       => 'require|max:5',
            'period'    => 'require|max:5',

            'week'      => 'require|max:99',

            'course_id' => 'require|max:999'
        ];
        $msg = [
            'day'       => '星期不能为空',
            'period'    => '节数不能为空',
            'week'      => '周次必选',
            'course_id' => 'course_id不能为空'
        ];
        $ct = [
            'day'       => $ct['day'],
            'period'    => $ct['period'],
            'week'      => $ct['week'],
            'course_id' => $ct['course_id']
        ];
        
        $validate   = Validate::make($rule,$msg);
        $result = $validate->check($ct);

        if(!$result) {
        return $validate->getError();
        }
        // 计算该学生选择课程数
        $num = count($ct['week']);
        
        for ($i=0; $i < $num ; $i++) { 
         // 实例化新的学生课程关系表
         $classtime = new ClassTime;
         // 将学生Id和课程Id存储到数据表
         $classtime->week = $ct['week'][$i];
         $classtime->day = $ct['day'];
         $classtime->period = $ct['period'];
         $classtime->course_id = $ct['course_id'];
         // 保存并验证
         
         $save = $classtime->save();
         // 若失败则跳出循环并返回
         if (!$save) {
             return $this->error('保存失败');
         }
     }
     //全部成功后返回
        $state = Db::table('term')->where('state', 1)->value('state');
        if($state === 0){
            return $this->error('所选课程的学期为空无法保存');
        }

     //全部成功后返回

     return $this->success('保存成功',url('index'));
   
    }
    
}