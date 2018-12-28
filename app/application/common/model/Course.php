<?php
namespace app\common\model;
use app\common\validate\CourseValidate;
use think\Model;

class Course extends Model
{
    private static $validate;

    public function save($data = [], $where = [], $sequence = null)
    {
        if (!$this->validate($this)) {
            return false;
        }
        return parent::save($data, $where, $sequence);
    }

    private function validate() {
        if (is_null(self::$validate)) {
            self::$validate = new CourseValidate();
        }
        return self::$validate->check($this);
    }

    public function search($pageSize , $Course){
        if (!empty($Course)) {

            $this->where('name' . $Course );
        }

        $Courses = $this->paginate($pageSize , false , [
            'query' => [
                'name'     => $Course,
                'pageSize' => $pageSize
                ],
            ]);
            
        return $Courses;
    }
}