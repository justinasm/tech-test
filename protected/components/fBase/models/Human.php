<?php

require_once(__DIR__ . '/../lib/FileProcessor.php');

class Human extends FileProcessor
{
    public $firstName;
    public $surname;

    public function __construct()
    {
        //set the model name and create an empty file if not exists
        $this->modelName = serverConfig('HUMAN_MODEL');
        parent::__construct(serverConfig('DATA_FILE_LOCATION') . serverConfig('HUMAN_MODEL'));
    }
}