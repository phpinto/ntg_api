<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Load;
use App\Http\Resources\Load as LoadResource;
use Helpers;

class LoadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function allLoads()
    {
        $loads = Load::all();
        return LoadResource::collection($loads);  
    }
    public function singleLoad($id)
    {
        $load = Load::findOrFail($id);
        return new LoadResource($load);
    }
    public function matchingLoadsByID($id)
    {
        $load = Load::findOrFail($id);
        $shipZip = $load->SZip;
        $shipZip = Helpers::zipSwitcher($shipZip);
        $equipment = $load->Equipment;
        $equipment = strtoupper($equipment);
        $loadDateArray = retrieveDates($load->TrailerNumber,$load->TruckNumber);
        $i = 0;
        
        $matchingLoads = Load::where([
                                ['Driver', '=', $load->Driver],
                                ['TruckNumber', '!=', $load->TruckNumber],
                                ])->get();

        foreach ($matchingLoads as $match){
            
            $matchZip = $match->SZip;
            $matchZip = Helpers::zipSwitcher($matchZip);
            $matchEquipment = $match->Equipment;
            $matchEquipment = strtoupper($matchEquipment);

            $e20 = ['20FT CONTAINER', '20 STD', '20 HC'];
            $e40 = ['40FT CONTAINER', '40 STD', '40 HC'];

            if ($matchZip == $shipZip) {
               if ( $equipment == $matchEquipment
                    || (in_array($equipment, $e20) && in_array($matchEquipment, $e20)) 
                    || (in_array($equipment, $e40) && in_array($matchEquipment, $e40))) {
                        $matchDateArray = retrieveDates($match->TrailerNumber,$match->TruckNumber);
                        $matches[$i] = $match;
                        $i++; 
                }
            }
        }

        return $matches;       

    }

}
