<?php
namespace app\components;
class SearchHelper {

    public static function getAllDepartment() {
        $dep[] = ['id' => '','name' => 'Select Any'];
        $model = \app\models\Department::find()->all();
        if ($model) {
            foreach ($model as $item) {
                $dep[] = ['id' => $item->id, 'name' => $item->title . ", " . $item->district->name . "-" . $item->state->name];
            }
        }

        return $dep;
    }
    
    public static function getAllEmployeePosition($departmentID = null){
        $dep[] = ['id' => '','name' => 'Select Any'];
        if($departmentID != null){
            $model = \app\models\EmployeePosition::find()->where("department_id = $departmentID")->all();
        } else {
        $model = \app\models\EmployeePosition::find()->all();
        }
        if ($model) {
            foreach ($model as $item) {
                $dep[] = ['id' => $item->id, 'name' => $item->title];
            }
        }

        return $dep;
    }

}
