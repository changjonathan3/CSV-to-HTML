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
        system::printTable($table);
    }
}

class system{
    public static function printTable($table){
        echo $table;
    }
}


class html{
    public static function makeTable($allRecords){
        $count = 0;
        // start table
        $html = '<table class="table table-striped">';

        foreach($allRecords as $record){
            if ($count == 0){
                $html .= '<thead>';
                $html .= '<tr>';
                $array = $record -> returnArray();
                $fields = array_keys($array);
                //print_r($fields);
                $values = array_values($array);
                //print_r($values);
                //print_r($values);
                //print_r($fields);
                //print_r($values);
                foreach($fields as $header){
                    $html .= '<th scope="col">' . htmlspecialchars($header) . '</th>';
                }
                $html .='</thead>';
                $html .='</tr>';
                $html .='<tbody>';
                $html .= '<tr>';
                //print_r($values);
                foreach($values as $data){
                    $html .= '<td>' . htmlspecialchars($data) . '</td>';
                }
                $html .= '</tr>';
            }
            else{
                $array = $record -> returnArray();
                $values = array_values($array);
                $html .= '<tr>';
                //print_r($values);
                foreach($values as $data){
                    $html .= '<td>' . htmlspecialchars($data) . '</td>';
                }
                $html .= '</tr>';
            }
            $count++;
            //print_r($record);

        }
        $html .='</tbody>';
        $html .='</table>';
        return $html;
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




