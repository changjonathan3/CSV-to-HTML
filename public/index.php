<?php
/**
 * Created by PhpStorm.
 * User: chang
 * Date: 2/5/2019
 * Time: 10:24 PM
 */
main::start();
class main {
    static public function start(){
        $file = fopen("example.csv","r");

        while(! feof($file))
        {
            print_r(fgetcsv($file));
        }

        fclose($file);
    }
}




