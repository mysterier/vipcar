<?php

class UserController extends Controller
{
    // public $brea
    public function actionIndex()
    {}

    public function actionList()
    {
        //超级账户禁止修改
        $criteria = new CDbCriteria();
        $criteria->condition = 'name != :name';
        $criteria->params = [
            'name' => 'admin'
        ];
        $dataProvider = new CActiveDataProvider('Admin', [
            'pagination' => [
                'pageVar' => 'page',
                'pageSize' => ADMIN_PAGE_SIZE
            ],
            'criteria' => $criteria
        ]);
        
        $template = '';
        $template .= $this->checkAccess(MODIFY_ADMIN) ? '{update}' : '';
        $template .= $this->checkAccess(DEL_ADMIN) ? ' {delete}' : '';
        $hash['gridDataProvider'] = $dataProvider;
        $hash['gridColumns'] = [
            [
                'name' => 'id',
                'header' => '序号',
                'htmlOptions' => [
                    'style' => 'width: 60px'
                ]
            ],
            [
                'name' => 'name',
                'header' => '用户名'
            ],
            [
                'header' => '角色',
                'value' => 'Yii::app()->controller->getRole($data)'
            ],
            [
                'name' => 'created',
                'header' => '创建时间'
            ],
            [
                'htmlOptions' => [
                    'nowrap' => 'nowrap'
                ],
                'header' => '操作',
                'class' => 'booster.widgets.TbButtonColumn',
                'template' => $template,
                'updateButtonUrl' => 'Yii::app()->controller->createUrl("modify", ["id" => $data->id])',
                'deleteButtonUrl' => 'Yii::app()->controller->createUrl("del", ["id" => $data->id])',               
            ]
        ];
        $this->breadcrumbs = [
            '后台用户管理'
        ];
        $this->render('list', $hash);
    }

    public function getRole($data)
    {
        $auth = Yii::app()->authManager;
        $role = $auth->getRoles($data->name);
        if ($role) {
            $name = array_keys($role);
            return $name[0];
        }
        return '待分配角色';
    }

    public function actionNew()
    {
        $this->breadcrumbs = [
            '后台用户管理' => [
                '/user/list'
            ],
            '新建客户'
        ];
        
        $model = new Admin();
        $this->saveUsers($model);
    }

    public function actionModify($id)
    {
        $this->breadcrumbs = [
            '客户管理' => [
                '/user/list'
            ],
            '修改客户'
        ];
        $model = Admin::model()->findByPk($id);
        $this->saveUsers($model);
    }

    private function saveUsers($model)
    {   
        $auth = Yii::app()->authManager;
        $roles = $auth->getRoles();
        $roles_name = [];
        $selectd = $this->getRole($model);
        foreach ($roles as $role) {
            if ($role->name != ADMINISTRATOR)
                $roles_name[] = $role->name;
        }
        if (isset($_POST['Admin'])) {
            if ($selectd != '待分配角色' && $model->name)
                $auth->revoke($selectd, $model->name);
            
            $old_pass = $model->passwd;
            $model->attributes = $_POST['Admin'];
            if ($model->validate()) {
                if ($old_pass != $model->passwd)
                    $model->passwd = $this->encryptPasswd($model->passwd);
                
                if ($model->save(false)) {
                    $role = $this->getParam('role');
                    if ($role)
                        $auth->assign($role, $model->name);
                    $this->redirect('/user/list');
                }                  
            }
        }
        $hash['model'] = $model;
        $hash['roles'] = $roles_name;
        $hash['selected'] = $selectd;
        $this->render('userform', $hash);
    }

    public function actionDel($id)
    {
        $model = Admin::model()->findByPk($id);
        $auth = Yii::app()->authManager;
        $auth->removeAuthItem($model->name);
        $model->delete();
        exit();
    }
    
    // ======以下为user
    public function actionAuth()
    {
        $auth = Yii::app()->authManager;
        $user = Yii::app()->user->id;
        $role = isset($_GET['role']) ? $_GET['role'] : '';
        $roles = $auth->getRoles();
        $role_name = [];
        foreach ($roles as $value) {
            if ($value->name == ADMINISTRATOR)
                continue;
            $role = $role ? $role : $value->name;
            $role_name[] = $value->name;
        }
        $children = $role ? $auth->getAuthItem($role)->getChildren() : [];
        $hash['roles'] = $role_name;
        $hash['role'] = $role;
        $hash['children'] = array_keys($children);
        $hash['task_operation'] = include (COMMON . '/config/auth.php');
        $task = $auth->getTasks();
        $this->render('auth', $hash);
    }

    public function actionModifyauth()
    {
        $role_name = $this->getParam('role');
        $operations = isset($_POST['auth_operations']) ? $_POST['auth_operations'] : [];
        $auth = Yii::app()->authManager;
        $auth->removeAuthItem($role_name);
        $role = $auth->createRole($role_name, $role_name);
        foreach ($operations as $op)
            $role->addChild($op);
            // var_dump(Yii::app()>request>urlReferrer);mark！会报错！似乎和session有关
        $this->redirect('/user/auth?role=' . $role_name);
    }

    public function actionCreaterole()
    {
        $role = $this->getParam('role');
        $desc = $this->getParam('desc');
        $desc = $desc ? $desc : $role;
        if ($role) {
            $auth = Yii::app()->authManager;
            $auth->createRole($role, $desc);
            $this->redirect('/user/auth?role=' . $role);
        }
        $this->render('roleform');
    }

    public function actionDelrole()
    {
        $role = $_GET['role'];
        $auth = Yii::app()->authManager;
        $auth->removeAuthItem($role);
        $this->redirect('/user/auth');
    }

    public function accessRules()
    {
        return [
            [
                'allow',
                'actions' => [
                    'auth'
                ],
                'roles' => [
                    VIEW_AUTH
                ]
            ],
            [
                'allow',
                'actions' => [
                    'modifyauth'
                ],
                'roles' => [
                    MODIFY_AUTH
                ]
            ],
            [
                'allow',
                'actions' => [
                    'createrole'
                ],
                'roles' => [
                    NEW_ROLE
                ]
            ],
            [
                'allow',
                'actions' => [
                    'delrole'
                ],
                'roles' => [
                    DEL_ROLE
                ]
            ],
            [
                'allow',
                'actions' => [
                    'list'
                ],
                'roles' => [
                    VIEW_ADMIN
                ]
            ],
            [
                'allow',
                'actions' => [
                    'new'
                ],
                'roles' => [
                    NEW_ADMIN
                ]
            ],
            [
                'allow',
                'actions' => [
                    'modify'
                ],
                'roles' => [
                    MODIFY_ADMIN
                ]
            ],
            [
                'allow',
                'actions' => [
                    'del'
                ],
                'roles' => [
                    DEL_ADMIN
                ]
            ],
            [
                'deny',
                'users' => [
                    '*'
                ],
                'deniedCallback' => function ($rule) {
                    header("location: /");
                }
            ]
        ];
    }
}