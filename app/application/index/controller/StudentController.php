<?php 
namespace app\index\controller;
use app\index\model\Student;
use app\common\model\Course;
use app\index\model\StudentCourses;
use think\Controller;
use think\Db;
use think\facade\Request;


class StudentController extends Controller
{
    public function index() {

        // 获取查询信息
        $name = Request::instance()->get('name');
        // 查询框内的默认值
        $this->assign('names',$name);

        $pageSize = 5;  // 每页显示五条数据
        // 实例化学生
        $Student = new Student;

        // 如果查询框不为空，则查询
        if (!empty($name)) {
            $Student = $Student->where('name', 'like', '%' . $name . '%');
        }
        // 按照id进行倒序排列，并保留查询时候的输入内容
        $Student = $Student->order('id desc')->paginate($pageSize,false, [
                'query'=>[
                    'name' => $name,
                    ]]);

        // 向v层传数据
        $this->assign('students',$Student);
        //取回打包后的数据
        $htmls = $this->fetch();
        // 将数据返回用户
        return $htmls;
    }
    
    // 增加
    public function add() {

        // 调用add模板
        return $this->fetch();
        
    }

    // add界面的保存
    public function save() {

        // 实例化
        $student = new Student;
        $stu = Request::post();
        // 设置属性
        $student->name = $stu['name'];
        $student->password = $stu['password'];
        $student->username = $stu["username"];
        $student->tel = $stu["tel"];
        $student->coefficient = $stu["coefficient"];
        // 保存
        $state = $student->save();

        if ($state) {
            return $this->success('保存成功',url('index'));
        } else {
            return $this->error('保存失败');
        }
    }

    // 编辑
    public function edit() {

        // 获取传入ID
         $id=request()->param('id/d');
        // $id = Request::instance()->param('id/d');
        // 判断是否成功接收
        if (is_null($id) || 0=== $id) {
            throw new \Exception("未获取到id信息", 1);
        }
        // 在Student表模型中获取当前记录
        if (null === $Student = Student::get($id))
        {
            // 由于在$this->error抛出了异常，所以也可省略return
            $this->error ('系统为找到ID为' . $id . '的记录');
        }
        // 将数据传给V层
        $this->assign('Student', $Student);
        // 获取封装好的V层内容
        $htmls = $this->fetch();
        // 将封装好的V层内容返回给用户
        return $htmls;
    }
    // 删除
    public function delete() {

        // 实例化请求类
        $Request = Request::instance();
        // 获取get数据
        $id = Request::instance()->param('id/d');
        // 判断是否成功接收
        if (0 === $id) {
            throw new \Exception("未获取到ID信息", 1);
        }
        // 获取要删除的对象
        $Student = Student::get($id);
        // 要删除的对象不存在
        if (is_null($Student)) {
            throw new \Exception("不存在id为" . $id . '的学生，删除失败', 1);
        }
        // 删除对象
        if (!$Student->delete()) {
            return $this->error('删除失败:' . $Student->getError());
        }
        // 进行跳转
        return $this->success('删除成功', $Request->header('referer'));
    }

    public function update() {

        $stu = Request::post();
        $student = Student::get(Request::post('id'));
        var_dump($student);
        
        $student->name = $stu['name'];
        $student->password = $stu['password'];
        $student->tel = $stu['tel'];
        $student->coefficient = $stu['coefficient'];

        $state = $student->save();

        if ($state) {
            return $this->success('保存成功',url('index'));
        } else {
            return $this->error('保存失败');
        }
    }

    // 选择课程
    public function change() {

        // 获取当前点击的学生id
        $student = Student::get(Request::param('id/d'));
        // 获取数据表中的所有课程id
        $courses = Course::order('id desc')->paginate(5);

        // 将获取的数据传到V层
        $this->assign('courses',$courses);
        $this->assign('student',$student);

        return $this->fetch();
    }

    // 选课界面的保存选项
    public function saveKlass() {

        // 获取学生id和课程id
        $stuCourse = Request::post();

        // 计算该学生选择课程数
        $num = count($stuCourse['courseId']);

        for ($i=0; $i < $num ; $i++) { 

            // 实例化新的学生课程关系表
            $studentCourses = new StudentCourses;

            // 将学生Id和课程Id存储到数据表
            $studentCourses->student_id = $stuCourse['studentId'];
            $studentCourses->courses_id = $stuCourse['courseId'][$i];

            // 保存并验证
            $state = $studentCourses->save();

            // 若失败则跳出循环并返回
            if (!$state) {

                return $this->error('保存失败');
            }
        }
        // 全部成功后返回
        return $this->success('保存成功',url('index'));
    }

}