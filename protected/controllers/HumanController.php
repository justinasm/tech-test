<?php

class HumanController extends Controller
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
                'actions' => ['view',],
                'users'   => ['*'],
            ],
            [
                'deny',  //deny all users
                'users' => ['*'],
            ],
        ];
    }

    public function actionView()
    {
        $humanId = (int) Yii::app()->getRequest()->getQuery('id');
        $human = new Human($humanId);

        if (!is_null($human->id)) {
            $view = 'view';
        } else {
            $view = 'no_human';
        }

        $this->render(
            $view,
            ['human' => $human]
        );
    }
}