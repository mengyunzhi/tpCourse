<?php 
namespace app\index\model;
use app\index\model\ContributionRecord;
use think\Model;

/**
 * 
 */
class Student extends Model
{
    public function getMonthTotal() {

        // get month begin time
        $time = strtotime('first day of this month');

        // get current time
        $contri = ContributionRecord::where('student_id',$this->id)->select();

        $nub = 0;

        $num = count($contri);

        // get sum
        for ($i = 0; $i < $num; $i ++) { 

            if (strtotime($contri[$i]['time']) - $time > 0) {

               $nub += $contri[$i]['contribution'];

            }
        }
        
        // return
        return $nub;
    }

    public function getWeekTotal() {

        $time = strtotime('monday this week');
        
        // get current time
        $contri = ContributionRecord::where('student_id',$this->id)->select();

        $nub = 0;

        $num = count($contri);

        // get sum
        for ($i=0; $i < $num; $i++) { 

            if (strtotime($contri[$i]['time']) - $time > 0) {

               $nub += $contri[$i]['contribution'];

            }
        }
        
        // return
        return $nub;
    }
}