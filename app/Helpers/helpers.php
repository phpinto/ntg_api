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

    public static function retrieveDates($trailerNumber,$truckNumber)
    {
        $trailerNumber = strtoupper($trailerNumber);
        $trailerNumber = str_replace(' ', '', $trailerNumber);
        $trailerNumber = str_replace(':', '', $trailerNumber);
        $trailerNumber = str_replace(';', '', $trailerNumber);
        $trailerNumber = str_replace('-', '', $trailerNumber);

        if ($truckNumber == 'IMPORT') {
            $etaPos = strpos($trailerNumber,"ETA");
            $lfdPos = strpos($trailerNumber,"LFD");
            if ($etaPos != '' && $lfdPos =='') {
                $etaDate = str_replace('ETA', '', $trailerNumber);
                $lfdDate = date( "m-d", strtotime( "$etaDate +4 day" ) );
                $etaDate = date( "m-d", strtotime( $etaDate ) );
                return array($etaDate, $lfdDate);
            }
            else if ($etaPos == '' && $lfdPos !='') {
                $lfdDate = str_replace('LFD', '', $trailerNumber);
                $etaDate = date( "m-d", strtotime( "$lfdDate -4 day" ) );
                $lfdDate = date( "m-d", strtotime( $lfdDate ) );
                return array($etaDate, $lfdDate);
            }
            else if ($etaPos != '' && $lfdPos !='') {
                if ($etaPos < $lfdPos) {
                    $etaDate = substr($trailerNumber,($etaPos + 3),($lfdPos - ($etaPos + 3)));
                    $lfdDate = substr($trailerNumber, ($lfdPos + 3));
                }
                else if ($etaPos > $lfdPos) {
                    $lfdDate = substr($trailerNumber,($lfdPos + 3),($etaPos - ($lfdPos + 3)));
                    $etaDate = substr($trailerNumber, ($etaPos + 3));
                }
                $etaDate = date( "m-d", strtotime($etaDate));
                $lfdDate = date( "m-d", strtotime($lfdDate));
                return array($etaDate, $lfdDate);
            }
        }

        if ($truckNumber == 'EXPORT') {
            $cutPos = strpos($trailerNumber,"CUT");
            $erdPos = strpos($trailerNumber,"ERD");
            if ($cutPos != '' && $erdPos =='') {
                $cutDate = str_replace('CUT', '', $trailerNumber);
                $erdDate = date( "m-d", strtotime( "$cutDate -4 day" ) );
                $cutDate = date( "m-d", strtotime( $cutDate ) );
                return array($cutDate, $erdDate);
            }
            else if ($cutPos == '' && $erdPos !='') {
                $erdDate = str_replace('ERD', '', $trailerNumber);
                $cutDate = date( "m-d", strtotime( "$erdDate +4 day" ) );
                $erdDate = date( "m-d", strtotime( $erdDate ) );
                return array($cutDate, $erdDate);
            }
            else if ($cutPos != '' && $erdPos !='') {
                if ($cutPos < $erdPos) {
                    $cutDate = substr($trailerNumber,($cutPos + 3),($erdPos - ($cutPos + 3)));
                    $erdDate = substr($trailerNumber, ($erdPos + 3));
                }
                else if ($cutPos > $erdPos) {
                    $erdDate = substr($trailerNumber,($erdPos + 3),($cutPos - ($erdPos + 3)));
                    $cutDate = substr($trailerNumber, ($cutPos + 3));
                }
                $cutDate = date( "m-d", strtotime($cutDate));
                $erdDate = date( "m-d", strtotime($erdDate));
                return array($cutDate, $erdDate);
            }
        }
    }
}

?>