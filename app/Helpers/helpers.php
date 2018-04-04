<?php

class Helpers {

    public static function zipSwitcher($zipCode)
    {
        if(strlen($zipCode) == 5) {
            $zipCode = substr($zipCode, 0, 3);
        }
        else if(strlen($zipCode) == 4) {
            $zipCode = substr($zipCode, 0, 2);
            $zipCode = '0'.$zipCode;
        }
        else if(strlen($zipCode) == 3) {
            $zipCode = substr($zipCode, 0, 1);
            $zipCode = '00'.$zipCode;
        }
        return $zipCode;
    }

    public static function retrieveDates($trailerNumber)
    {
        $trailerNumber = str_replace(' ', '', $trailerNumber);
        $label = substr($trailerNumber,0,3);
        $date = substring($trailerNumber,3);
    }


}

?>