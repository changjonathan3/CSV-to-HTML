<?php
/**
 * Created by PhpStorm.
 * User: chang
 * Date: 2/5/2019
 * Time: 10:24 PM
 */
main::start('example.csv');
class main {
    static public function start($file){
        $allRecords = csv::getRecords($file);
        $record = recordFactory::create();
        print_r($record);
    }
}

class csv{
    static public function getRecords($file){
        $file = fopen($file,"r");

        while(! feof($file))
        {
            $record = fgetcsv($file);
            $allRecords [] = $record;
        }

        fclose($file);
        return $allRecords;
    }
}

class record{

}

class recordFactory{
    public static function create(Array $array = null){
        $record = new record();
        return $record;
    }
}




