<?php
namespace app\index\controller;
use app\index\model\ContributionRecord;
use app\index\model\Student;
use think\Controller;
use think\Db;
use think\facade\Request;
use think\model\Collection;

/**
 * hu
 */
class ContributionRecordController extends PassController
{
    
    // 主界面
    public function index() 
    {

        // 获取所有学生的信息
        $student = Student::select();
        $this->assign('student',$student);

        return $this->fetch();

    }

    // 贡献值详细信息页面
    public function detail() 
    {

        // 获取点击事件的学生id
        $id = Request::param('id');

        // 获取贡献值管理的当前学生id的贡献值信息
        $contri = ContributionRecord::where('student_id',$id)->select();

        // 数据传递到V层
        $this->assign('contri',$contri);
        
        return $this->fetch();
    }

    // 添加贡献值页面
    public function add() 
    {

        // 获取当前点击id
        $id = Request::param('id');

        // 获取当前id的学生信息
        $student = Student::where('id',$id)->select();

        // 将学生信息传给V层
        $this->assign('student',$student);

        return $this->fetch();
    }

    // 添加贡献值页面的保存按钮
    public function save() 
    {

        // 获取V层数据
        $pos = Request::post();

        // 实例化贡献值管理的数据
        $contri = new ContributionRecord;

        // 获取当前学生的id
        $student = Student::get(Request::get('id'));

        // 让原有的学生贡献值加上新增的。
        if ($pos['edit'] == 0) {
            $student['contribution'] += $pos['number'];

        } else if($pos['edit'] == 1) {

            $student['contribution'] -= $pos['number'];
        } else {
            return 'error1';
        }

        // 将V层的数据分别赋值给贡献值管理数据表和学生数据表
        $contri->time = date('Y-m-d H:i:s');
        $contri->title = '贡献值修改';
        $contri->remark = $pos['remark'];
        $contri->student_id = Request::get('id');
        $contri->contribution = $pos['number'];

        // 保存数据
        $student->save();
        $state = $contri->save();


        // 依据状态定制提示信息
        if ($state) {
            return $this->success('保存成功',url('index'));
        } else {
            return $this->error('保存失败');
        }
    }
    
}