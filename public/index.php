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
    }
}

class csv{
    static public function getRecords($file){
        $file = fopen($file,"r");

        while(! feof($file))
        {
            $record = fgetcsv($file);
            $allRecords [] = recordFactory::create($record);
        }

        fclose($file);
        return $allRecords;
    }
}

class record{
    public function __construct(Array $record = null){
        $this ->createProperty();
        print_r($this);
    }
    public function createProperty($name = 'first', $value = 'Adam'){
        $this ->{$name} = $value;
    }
}

class recordFactory{
    public static function create(Array $array = null){
        $record = new record($array);
        return $record;
    }
}




