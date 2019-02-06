<?php
/**
 * Created by PhpStorm.
 * User: chang
 * Date: 2/5/2019
 * Time: 10:24 PM
 */
main::start();
class main {
    static public function start($fileName){
        $records = csv::getRecords($fileName);
        print_r($records);
    }
}

class csv{
    static public function getRecords($fileName){
        $file = fopen($fileName, "r");
        while(! feof($file)){
            $record = fgetcsv($file);
            $records [] = recordFactory::create($record);
        }
        fclose($file);
        return $records;

    }
}

class html{

}

class system{

}

class record
{
    public function __construct(Array $record = null){
        print_r($record);
}
}

class recordFactory
{
    public static function create(Array $array = null)
    {
        $record = new record($array);
        return $record;
    }
}
