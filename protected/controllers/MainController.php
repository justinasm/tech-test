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
                'actions' => ['index', 'error', 'addmore', 'updateform',],
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
        $existingPeople = Yii::app()->getRequest()->getPost('people', []);
        $newPeople = Yii::app()->getRequest()->getPost('new-people', []);
        $errors = array_merge(
            Human::validateHumanData($existingPeople),
            Human::validateHumanData($newPeople, true)
        );

        if (empty($errors)) {
            Human::removePeople();
            $people = array_merge(
                $newPeople,
                $existingPeople
            );

            foreach ($people as $human) {
                if (trim($human['firstName']) != '' && trim($human['surname']) != '') {
                    $humanModel = new Human();
                    $humanModel->attributes = $human;
                    $humanModel->create(
                        !is_null($humanModel->id) ? $humanModel->id : null
                    );
                }
            }
        }

        $this->actionIndex(true, $errors);
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

    public function actionIndex($partial = false, $errors = [])
    {
        $humanModel = new Human();
        $renderFunction = $partial ? 'renderPartial' : 'render';

        $this->$renderFunction(
            'index',
            [
                'people' => $humanModel->findAll(),
                'errors' => $errors,
            ]
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