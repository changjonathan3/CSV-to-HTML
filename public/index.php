<?php
/**
 * Created by PhpStorm.
 * User: chang
 * Date: 2/5/2019
 * Time: 10:24 PM
 */
main::start('example.csv');
class main {
    public static function start($file){
        $allRecords = csv::getRecords($file);
        $table = html::makeTable($allRecords);

    }
}

class html{
    public static function makeTable($allRecords){
        $count = 0;

        foreach($allRecords as $record){
            if ($count == 0){
                $array = $record -> returnArray();
                $fields = array_keys($array);
                $values = array_values($array);
                print_r($fields);
                print_r($values);
            }
            else{
                $array = $record -> returnArray();
                $values = array_values($array);
                print_r($values);
            }
            $count++;
            //print_r($record);

        }
    }
}

class csv{
    public static function getRecords($file){
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

        $c=array_combine($header,$values);
        foreach($c as $key => $value){
            $this ->createProperty($key, $value);
        }
        //print_r($this);

    }

    public function returnArray(){
        $array = (array) $this;
        return $array;
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




