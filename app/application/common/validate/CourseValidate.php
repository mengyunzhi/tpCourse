<?php
namespace app\common\validate;
use think\Validate;   

class CourseValidate extends Validate
{
    protected $rule = [
        'name' => 'require|length:2,25',
    ];
}
