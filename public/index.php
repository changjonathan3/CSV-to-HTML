
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
        echo $table;
    }
}

class table{
    public static function returnTable($table) {
        return '<table class="table table-striped">' . self::returnTHead($table) . '</table>';
    }
}

class html{
    /**
     * @param $allRecords
     *          Take the array generated from the CSV file and set data to output as HTML
     */
    public static function makeTable($allRecords){
        $count = 0;
        // start table
        echo "<table class=\"table table-striped\">";
        foreach($allRecords as $record){
            if ($count == 0){
                $array = $record -> returnArray();
                $fields = array_keys($array);
                //output the header rows
                //print_r($fields);
                self::returnHeader($fields);

                //output the first data row
                $values = array_values($array);
                //print_r($values);
                echo "<tbody>";
                self::returnData($values);
            }
            else{
                $array = $record -> returnArray();
                $values = array_values($array);
                //output the other data rows
                //print_r($values);
                self::returnData($values);
            }
            $count++;
        }
        echo "</tbody>";
        echo "</table>";
    }
    public static function returnHeader($th) {
        echo "<thead><tr>";
        foreach($th as $header){
            echo '<th>' . $header. '</th>';
        }
        echo "</tr></thead>";
    }
    public static function returnData($td) {
        echo "<tr>";
        foreach($td as $data){
            echo '<td>' . $data. '</td>';
        }
        echo "</tr>";
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

</html>
