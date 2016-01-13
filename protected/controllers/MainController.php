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
                'actions' => ['index', 'error'],
                'users'   => ['*'],
            ],
            [
                'deny',  //deny all users
                'users' => ['*'],
            ],
        ];
    }

    public function actionIndex()
    {
        $this->render('index');
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