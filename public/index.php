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
        $records = csv::getRecords($file);
        print_r($records);
    }
}

class csv{
    static public function getRecords($file){
        $file = fopen($file,"r");

        while(! feof($file))
        {
            $record = fgetcsv($file);
            $records [] = $record;
        }

        fclose($file);
        return $records;
    }
}




