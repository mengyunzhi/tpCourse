<?php 
namespace app\index\controller;
use app\index\model\Student;
use app\common\model\Course;
use app\index\model\StudentCourses;
use think\Controller;
use think\facade\Request;


class StudentController extends Controller
{
    public function index()
    {
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
    public function add()
    {
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
    public function edit()
    {
        try
        {
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
        // 获取到ThinkPHP的内置异常时，直接向上抛出，交给ThinkPHP处理
        } catch (\think\Exception\HttpResponseException $e) {
            throw $e;
        // 获取到正常异常时，输出异常
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    // 删除
    public function delete()
    {
        try {
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
        // 获取到Thinkphp的内置异常时，直接向上抛出，交给thinkphp处理
        } catch (\think\Exception\HttpResponseException $e) {
        throw $e;
        // 获取到正常异常时，输出异常
        } catch (\think\Exception $e) {
            return $e->getMessage();
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

        $student = Student::get(Request::param('id/d'));
        $courses = Course::order('id desc')->paginate(5);
        var_dump($student);
        $this->assign('courses',$courses);
        $this->assign('student',$student);

        return $this->fetch();
    }

    public function saveKlass() {
        // 获取学生id和课程id
        $stuCourse = Request::post();
        $studentCourses = new StudentCourses;
        
    }

 }