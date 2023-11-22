<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\components;

/**
 * Description of GeneralHelper
 *
 * @author deepak
 */
class GeneralHelper {

    public static function getErrorAsString($model) {
        ob_start();
        echo "<pre>";
        print_r($model->getErrors());
        echo "</pre>";
        $str = ob_get_contents();
        ob_end_flush();
        return $str;
    }

    public static function getUserRole($id) {
        $roles = \Yii::$app->authManager->getRolesByUser($id);
        $retArr = [];
        if ($roles) {
            foreach ($roles as $i => $item) {
                $retArr[] = $i;
            }
        }
        
        return $retArr;
        /*if (isset($retArr[0]) && $retArr[0] != '') {
            return $retArr[0];
        } else {
            return "Registered";
        }*/
    }
    
    public static function getAllRoles(){
        $retArr = [];
        $roles = \Yii::$app->authManager->getRoles();
        foreach($roles as $index => $role){
            $retArr[$index] = $index;
        }
        return $retArr;
    }
    
    public static function revokeUserRoles($userID){
        $roles = self::getUserRole($userID);
        if(count($roles) > 0){
            foreach($roles as $index => $role){
                \Yii::$app->authManager->revoke(\Yii::$app->authManager->getRole($role), $userID);
            }
        }
        
    }

}
