<!DOCTYPE html>
<html>
<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Jonathan Chang</title>
</head>
<body>

<?php
/**
 * Created by PhpStorm.
 * @author Jonathan Chang
 * Date: 2/5/2019
 * Time: 10:24 PM
 * For IS 601 Project 1
 */

main::start('example.csv');

class main {
    public static function start($file){
        $allRecords = csv::getRecords($file);
        $table = html::makeTable($allRecords);
        return table::returnTable($table);
    }
}

class table {
    public static function returnTable($table) {
        return '<table class="table table-striped">' . $table . '</table>';
    }

    public static function tr($row) {
        return '<tr>' . $row . '</tr>';
    }

    public static function returnHeader($th, $table) {
        //echo "<tr>";
        //$head = "<thead>";
        foreach($th as $header){
            $table.="<th>$header</th>";
            //echo "<th>$header</th>";
        }
        return $table;
    }

    public static function returnData($td, $table) {
        //echo "<tr>";
        //$row="<tr>";
        foreach($td as $data){
            //echo "<td>$data</td>";
            $table.= "<td>$data</td>";
        }
        return $table;
    }

}

class html{
    public static function makeTable($allRecords){
        $count = 0;
        // start table
        //echo "<table class=\"table table-striped\">";
        $table = "<thead>";
        //echo "<thead>";
        foreach($allRecords as $record){
            if ($count == 0){
                $array = $record -> returnArray();
                $fields = array_keys($array);
                $table = table::tr(table::returnHeader($fields, $table));
                $table.="</thead><tbody>";
                //echo "</tr></thead><tbody>";

                //output the first data row
                $values = array_values($array);
                $table = table::tr(table::returnData($values, $table));

                //echo "</tr>";
                //print_r($values);
                //table::returnData($values);
            }
            else{
                $array = $record -> returnArray();
                $values = array_values($array);
                $table = table::tr(table::returnData($values, $table));
                //echo "</tr>";
            }
            $count++;
        }
        //echo "</tbody>";
        //echo "</table>";
        //print_r($table);
        $table.="</tbody>";

        return $table;
    }
}

class csv{
    /**
     * @param $file  CSV input file to read
     * @return array The output array to be transformed
     */
    public static function getRecords($file){
        $file = fopen($file,"r");
        $header = array();
        $allRecords = array();
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
    /**
     * record constructor.
     * @param array|null $header
     *          Header row in file
     * @param null $values
     *          Data values mapped to column headers
     */
    public function __construct(Array $header = null, $values = null){
        $c=array_combine($header,$values);
        foreach($c as $key => $value){
            $this ->createProperty($key, $value);
        }
    }

    /**
     * @return array CSV file read into array
     */
    public function returnArray(){
        $array = (array) $this;
        return $array;
    }

    /**
     * @param string $name
     *      Header column values
     * @param string $value
     *      Data cell values
     */
    private function createProperty($name = 'first', $value = 'Adam'){
        $this ->{$name} = $value;
    }
}

class recordFactory{
    /**
     * @param array|null $header
     *          Header column values
     * @param null $values
     *          Data cell values
     * @return record
     *          Header and Data pair
     */
    public static function create(Array $header = null, $values = null){

        $record = new record($header, $values);
        return $record;
    }
}
?>
<br/>
</body>
</html>
