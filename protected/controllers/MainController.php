<?php

class MainController extends Controller
{
    public function filters()
    {
        return [
            'accessControl',
        ];
    }

    /**
     * @return array access control rules
     */
    public function accessRules()
    {
        return [
            [
                'allow',  //allow all users to perform actions below
                'actions' => ['index', 'error', 'addmore', 'updateform'],
                'users'   => ['*'],
            ],
            [
                'deny',  //deny all users
                'users' => ['*'],
            ],
        ];
    }

    public function actionUpdateForm()
    {
        $newPeople = Yii::app()->getRequest()->getPost('new-people', []);

        foreach ($newPeople as $human) {
            $humanModel = new Human();
            $humanModel->attributes = $human;
            $humanModel->create();
        }
    }

    public function actionAddMore()
    {
        $this->renderPartial(
            '_human_fields',
            [
                'new'   => true,
                'key'   => Yii::app()->getRequest()->getPost('key', 0),
            ]
        );
    }

    public function actionIndex()
    {
        $this->render(
            'index'
        );
    }

    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest) {
                echo $error['message'];
            } else {
                $this->render('error', $error);
            }
        }
    }
}