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
        system::printTable($table);
    }
}

class system{
    /**
     * @param $table Return the printed table
     */
    public static function printTable($table){
        echo $table;
    }
}

class html{
    /**
     * @param $allRecords
     *          Take the array generated from the CSV file and output it to an HTML table
     */
    public static function makeTable($allRecords){
        $count = 0;
        // start table
        echo "<html lang=\"en\">
                <head>
                    <!-- Required meta tags -->
                    <meta charset=\\'utf - 8\\>
                    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">
                    <!-- Bootstrap CSS -->
                    <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css\" integrity=\"sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm\" crossorigin=\"anonymous\">
                    <title>Jonathan Chang</title>
                </head>
                <table class=\"table table-striped\">
                <thead>";

        foreach($allRecords as $record){
            if ($count == 0){
                $array = $record -> returnArray();
                $fields = array_keys($array);
                //output the header rows
                self::dataOut($fields, $style = 1);

                echo "</thead>
                        <tbody>";

                //output the first data row
                $values = array_values($array);
                self::dataOut($values);
            }
            else{
                $array = $record -> returnArray();
                $values = array_values($array);
                //output the other data rows
                self::dataOut($values);
            }
            $count++;
        }
        echo "</tbody>
                </table>
                </html>";
        return ;
    }

    /**
     * @param array|null $array
     *        Read in either the header row array or the data row array
     * @param int $style
     *        Read in either 1 for header row markup or 2 for data row markup
     */
    private static function dataOut(Array $array = null, $style = 2){
        echo '<tr>';
        foreach($array as $data){
            if($style ==1){
                echo '<th>' . htmlspecialchars($data) . '</th>';
            }
            else{
                echo '<td>' . htmlspecialchars($data) . '</td>';
            }
        }
        echo '</tr>';
    }
}

class csv{
    /**
     * @param $file The CSV input file to read
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

