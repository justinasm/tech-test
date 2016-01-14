<?php

class FileProcessor
{
    public $webRoot;
    public $fileName;
    public $modelName;

    /**
     * @param $fileName string file name
     */
    public function __construct($fileName)
    {
        $this->fileName = Yii::getPathOfAlias('webroot') . $fileName;
        $this->createFileIfNotExists();
    }

    /**
     * @param $property
     * @return mixed
     */
    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    /**
     * @param $property
     * @param $value
     * @return $this
     */
    public function __set($property, $value) {
        if ($property == 'attributes' && is_array($value)) {
            foreach ($value as $key => $val) {
                if (property_exists($this, $key)) {
                    $this->$key = $val;
                }
            }
        } else {
            if (property_exists($this, $property)) {
                $this->$property = $value;
            }
        }

        return $this;
    }

    /**
     * Create an empty file
     * @return bool
     */
    private function createFile()
    {
        $file = fopen($this->fileName, 'w');

        if ($file) {
            fclose($file);

            return true;
        } else {

            return false;
        }
    }

    /**
     * Check if file exists
     * @return bool
     */
    private function fileExists()
    {
        if (file_exists($this->fileName)) {

            return true;
        } else {

            return false;
        }
    }

    /**
     * Create file if not exists in the given directory
     */
    private function createFileIfNotExists()
    {
        if (!$this->fileExists()) {
            $this->createFile();
        }
    }

    /**
     * count entries in the file
     * @return int count of rows in the file
     */
    public function countRows()
    {
        $lineCount = 0;
        $handle = fopen($this->fileName, 'r');

        while(!feof($handle)) {
            if (strlen(fgets($handle)) > 0) {
                $lineCount++;
            }
        }

        fclose($handle);

        return $lineCount;
    }

    /**
     * @return int
     */
    public function getLastId()
    {
        $lastRow = $this->findRowByKey($this->countRows());

        if ($lastRow) {

            return $lastRow->id;
        } else {

            return 0;
        }
    }

    /**
     * @param $key int
     * @return bool|mixed
     */
    public function findRowByKey($key)
    {
        $row = false;
        $counter = 0;
        $handle = fopen($this->fileName, 'r');

        while(!feof($handle)) {
            $row = preg_replace('~[\r\n]+~', '', fgets($handle));

            if (strlen($row) > 0) {
                $counter++;

                if ($counter == $key) {
                    break;
                }
            }
        }

        $row = trim($row) != '' ? $row : false;
        fclose($handle);

        return json_decode($row);
    }

    /**
     * Select all rows in the file
     * @return array|bool
     */
    public function findAll()
    {
        $rows = false;

        $data = file($this->fileName);

        if (!empty($data)) {
            foreach ($data as $key => $row) {
                $data[$key] = json_decode(preg_replace('~[\r\n]+~', '', $row));
            }

            $rows = $data;
        }

        return $rows;
    }

    /**
     * Delete row by key
     * @param $key int
     */
    public function deleteRowByKey($key)
    {
        $rowToRemove = json_encode($this->findRowByKey($key));

        if ($rowToRemove) {
            $data = file($this->fileName);
            $out = [];

            foreach($data as $line) {
                if(preg_replace('~[\r\n]+~', '', $line) != $rowToRemove) {
                    $out[] = $line;
                }
            }

            $fp = fopen($this->fileName, 'w+');
            flock($fp, LOCK_EX);

            foreach($out as $line) {
                fwrite($fp, $line);
            }

            flock($fp, LOCK_UN);
            fclose($fp);
        }
    }

    /**
     * @param $row array of data
     */
    public function saveRow($row)
    {
        $row = json_encode($row) . "\n";
        $handle = fopen($this->fileName, 'a');
        fwrite($handle, $row, strlen($row));
        fclose($handle);
    }
}