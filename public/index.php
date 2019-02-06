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
        $header = array();
        $count = 0;

        while(! feof($file))
        {
            $record = fgetcsv($file);
            if($count == 0){
                $header = $record;
            }
            else{
                $allRecords [] = recordFactory::create($header, $record);
            }
            $count++;
        }

        fclose($file);
        return $allRecords;
    }
}

class record{
    public function __construct(Array $header = null, $values = null){
        print_r($header);
        print_r($values);
        $this ->createProperty();
    }
    public function createProperty($name = 'first', $value = 'Adam'){
        $this ->{$name} = $value;
    }
}

class recordFactory{
    public static function create(Array $header = null, $values = null){

        $record = new record($header, $values);
        return $record;
    }
}




