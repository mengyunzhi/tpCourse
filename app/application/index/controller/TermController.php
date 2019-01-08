
<?php
namespace app\index\controller;
use think\Controller;
use think\facade\Request;
use app\common\model\Term; 
/**
 *学期管理
 */
class TermController extends Controller
{
    public function index()
    {
        $name         = Request::instance()->get('name');       //课程查询
        
        $Termpage   = Request::instance()->get('pageSize');     //分页

        $pageSize = 5;                                          //页数5条
        
        $Term       = new Term();
                                                                //定制查询条件倒序显示
        $terms      =$Term->where('name','like','%'.$name .'%')->order('id desc')->paginate($pageSize,false,[
            'query'=>[
            'name'=>$name,
            ],
        ]);

        $this->assign('terms', $terms);                         //将数据传给V层
        
        return $this->fetch();                                  //页面渲染
    }


    
    public function delete()
    {
        // 获取传入的ID值
        $id = Request::param('id/d');                           // “/d”表示将数值转化为“整形”

        if (is_null($id) || 0 === $id) {
            return $this->error('未获取到ID信息');
        }

        // 获取要删除的对象
        $Term = Term::get($id);

        // 要删除的对象不存在
        if (is_null($Term)) {
            return $this->error('不存在id为' . $id . '的学期，删除失败');
        }

        // 删除对象
        if (!$Term->delete()) {
            return $this->error('删除失败:' . $Term->getError());
        }

        // 进行跳转
        return $this->success('删除成功', url('index'));
    }
    public function edit()
    {
         // 获取传入ID
        $id = Request::param('id/d');

        // 在Term表模型中获取当前记录
        if (is_null($Term = Term::get($id))) {
            return '系统未找到ID为' . $id . '的记录';
        } 
        
        // 将数据传给V层
        $this->assign('Term', $Term);

        // 获取封装好的V层内容
        $htmls = $this->fetch();

        // 将封装好的V层内容返回给用户
        return $htmls;
    }
    public function save()
    {
        // 接收传入数据
        $postData = $_POST;    
        var_dump($_POST);
        // 实例化Term空对象
        $Term = new Term();
        
        // 为对象赋值
        $Term->name = $postData['name'];
        $Term->start_time = $postData['start_time'];
        $Term->end_time = $postData['end_time'];
        
        if (false   === $Term->save()) {                        // 依据状态定制提示信息
            return $this->error('添加失败' . $Term->getError());
        }
        return $this->success('添加成功', url('index'));         // 成功进行跳转
    }
    public function add()
    {
        return $this->fetch();
    }
    public function update()
    {
       try {
            // 接收数据，获取要更新的关键字信息
            $id = Request::instance()->post('id/d');
            $message = '更新成功';

            // 获取当前对象
            $Term = Term::get($id);
            if (!is_null($Term)) {
                // 写入要更新的数据
                $Term->name = Request::instance()->post('name');
                $Term->start_time = Request::instance()->post('start_time');
                $Term->end_time = Request::instance()->post('end_time');
                $Term->state = Request::instance()->post('state');

                // 更新
                if (false === $Term->save())
                {
                    $message =  '更新失败' . $Term->getError();
                }
            } else {
                throw new \Exception("所更新的记录不存在", 1);    // 调用PHP内置类时，需要在前面加上 \ 
            }
        } catch (\Exception $e) {

            $message = $e->getMessage();
        }
       
        return $this->success('更新成功', url('index'));
    }
    public function activation()
    {
        $terms = Term::all();

        // 通过循环实现状态值都设置为0
 
        foreach ($terms as $term) 
        {
        	if ($term->state != 0)
    		{
    			$term->state = 0;
    		    $term->save();
    	    }
        }
 
       // 把某学期状态设置为1
        $id = Request::instance()->param('id/d');
        
        $Term = Term::get($id);
        $Term->state = 1;

        // 保存
        $Term->save();
        // 实现url跳转('index')
        return $this->success('设置成功', url('index'));
	
    }

}