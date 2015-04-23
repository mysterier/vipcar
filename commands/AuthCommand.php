<?php
/**
 * 权限相关脚本
 * 
 * 建立后台基础权限选项
 * 
 * @author lqf
 *
 */
class AuthCommand extends CConsoleCommand
{
    /**
     * 建立权限选项
     * 命令：cli.php auth build
     * 
     * @author lqf
     */
    public function actionBuild() {
        $task_operation = include (COMMON . '/config/auth.php');
        $auth = Yii::app()->authManager;
        $role = $auth->createRole(ADMINISTRATOR, '超级管理员');
        foreach ($task_operation as $task => $operation) {
            $tasks = $auth->createTask($task, array_shift($operation));
            if ($operation) {
                foreach ($operation as $k => $v) {
                    $auth->createOperation($k, $v);
                    $tasks->addChild($k);
                }
            }
            $role->addChild($task);
        }
        //admin赋予超级管理员权限
        $auth->assign(ADMINISTRATOR, 'admin');
        echo 'success';
    }
}