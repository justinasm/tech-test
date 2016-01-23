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
        $this->saveRow(
            [
                'id'        => is_null($id) ? ++$lastId : $id,
                'firstName' => $this->firstName,
                'surname'   => $this->surname,
            ]
        );
    }

    public static function removePeople()
    {
        $humanModel = new Human();
        $humanModel->removeAll();
    }
}