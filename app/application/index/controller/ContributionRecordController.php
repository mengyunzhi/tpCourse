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
class ContributionRecordController extends Controller
{
    
    public function index() {

        $student = Student::select();
        $this->assign('student',$student);

        return $this->fetch();

    }

    public function detail() {

        $id = Request::param('id');
        $contri = ContributionRecord::where('student_id',$id)->select();
        $this->assign('contri',$contri);
        
        return $this->fetch();
    }

    public function edit() {


        return $this->fetch();
    }

    public function save() {
        $id = Request::param('id'); //获取不到
        var_dump($id);
        $pos = Request::post();
        if ($pos->add == true) {
            # code...
        }

        $contri = new ContributionRecord;

        $state = $contri->save($pos);

        // 依据状态定制提示信息
        if ($state) {
            return $this->success('保存成功',url('index'));
        } else {
            return $this->error('保存失败');
        }
    }
    
}