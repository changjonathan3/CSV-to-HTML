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
        //$html = '<table class="table table-striped">';
        echo
        "<html lang=\"en\">
            <head>
                <!-- Required meta tags -->
                <meta charset=\"utf-8\">
                <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">
                <!-- Bootstrap CSS -->
                <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css\" integrity=\"sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm\" crossorigin=\"anonymous\">
                <title>Project 1</title>
            </head>
            <table class=\"table table-striped\">
                <thead>
                    <tr>";

        foreach($allRecords as $record){
            if ($count == 0){

                $array = $record -> returnArray();
                $fields = array_keys($array);
                $values = array_values($array);

                foreach($fields as $header){
                    echo '<th scope="col">' . htmlspecialchars($header) . '</th>';
                }
                echo
                "</thead>
                      </tr> 
                        <tbody>";
                //dataOut($values);
                echo '<tr>';
                foreach($values as $data){
                    echo '<td>' . htmlspecialchars($data) . '</td>';
                }
                echo '</tr>';
            }
            else{
                $array = $record -> returnArray();
                $values = array_values($array);
                //$html .= '<tr>';
                //print_r($values);
                //dataOut($values);
                echo '<tr>';
                foreach($values as $data){
                    echo '<td>' . htmlspecialchars($data) . '</td>';
                }
                echo '</tr>';
            }
            $count++;
            //print_r($record);
        }
        echo"</tbody>
             </table>
             </html>";
        return ;
    }
    /**
    public static function dataOut(Array $array = null){
        echo '<tr>';
        foreach($array as $data){
            echo '<td>' . htmlspecialchars($data) . '</td>';
        }
        echo '</tr>';
    }
     * */
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

