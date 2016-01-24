<?php

require_once(__DIR__ . '/../lib/FileProcessor.php');

class Human extends FileProcessor
{
    public $id;
    public $firstName;
    public $surname;

    public function __construct($humanId = null)
    {
        //set the model name and create an empty file if not exists
        $this->modelName = serverConfig('HUMAN_MODEL');
        parent::__construct(serverConfig('DATA_FILE_LOCATION') . serverConfig('HUMAN_MODEL'));

        if (!is_null($humanId)) {
            $humanData = $this->findRowById($humanId);

            if ($humanData) {
                $this->attributes = $humanData;
            }
        }
    }

    public function create($id = null)
    {
        $lastId = $this->getLastId();

        $id = htmlspecialchars(is_null($id) ? ++$lastId : $id);

        $this->saveRow(
            [
                'id'        => is_null($id) ? ++$lastId : $id,
                'firstName' => htmlspecialchars($this->firstName),
                'surname'   => htmlspecialchars($this->surname),
            ]
        );
    }

    public static function removePeople()
    {
        $humanModel = new Human();
        $humanModel->removeAll();
    }

    public static function validateHumanData($data, $new = false)
    {
        $errors = [];

        foreach ($data as $human) {
            if (!$new
                && (!preg_match('/^[a-zA-Z\s]+$/', $human['firstName']) || !preg_match('/^[a-zA-Z\s]+$/', $human['surname']))
            ) {
                $errors[] = 'Names and Surname must contain only letters and cannot be empty.';
            }

            if ($new) {
                if ((!preg_match('/^[a-zA-Z\s]+$/', $human['firstName']) && $human['surname'] != '')
                    || trim($human['firstName']) != '' && !preg_match('/^[a-zA-Z\s]+$/', $human['surname'])) {
                    $errors[] = 'New human must have Name and Surname with only letter';
                }
            }

            if (!empty($errors)) {
                break;
            }
        }

        return $errors;
    }
}