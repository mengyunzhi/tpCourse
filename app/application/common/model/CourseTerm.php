<?php
namespace app\common\model;
use think\Model;

/**
 * 
 */
class CourseTerm extends Model
{
    
    public function index()
    {
        function __construct($Courseid = 0, $Termid = 0){
            $this->Course = $Courseid;
            $this->Term = $Termid;
        }
    
        public function getDays(){
            $days = [];
            for($temp = 1 ; $temp <= 7 ; $temp ++) {
                
                $Day      = new Day($temp , $this->Course , $this->Term);
                $Day->Day = $temp;
                array_push($days, $Day);
            }
    
            return $days;
        }
    }