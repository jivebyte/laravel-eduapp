<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use FarhanWazir\GoogleMaps\GMaps;
use DB;

class MapController extends Controller
{
    public function map($cat_id) {
        $config['center'] = 'USP Laucal Campus';
        $config['zoom'] = '16';
        $config['map_height'] = '500px';
        $config['map_width'] = '100%';
        $config['scrollwheel'] = false;
    // $config['geocodeCaching'] = true;
    // $config['cluster'] = true;
        $polyline = array();
        $polyline['points'] = [
            '-18.148307, 178.448507',
            '-18.14661845329001,178.44516098499298',
            '-18.145509210669708,178.44242035394836',
            '-18.145531640245967,178.44119190221954',
            '-18.146084223269444,178.4404462481134',
            '-18.147411638862863,178.44022630697418',
            '-18.147581, 178.440294',
            '-18.147999, 178.441077',
            '-18.147999, 178.441077',
            '-18.149375, 178.440508',
            '-18.149660, 178.440723',
            '-18.151210, 178.440197',
            '-18.151491, 178.440158',
            '-18.153087, 178.440490',
            '-18.153999, 178.441477',
            '-18.155138, 178.442713',
            '-18.156540, 178.444924',
            '-18.152813, 178.447971',
            '-18.151447, 178.446544',
            '-18.149194, 178.447424',
            '-18.149347, 178.448250',
            '-18.149347, 178.448250',
            '-18.148307, 178.448507'
        ];
        $polyline['clickable'] = true;                            // Defines if the polyline is clickable
        $polyline['strokeColor'] = '#FF0000';                    // The hex value of the polylines color
        $polyline['strokeOpacity'] = '1.0';                        // The opacity of the polyline. 0 to 1.0
        $polyline['strokeWeight'] = '2';                        // The thickness of the polyline

        // $locations = array();
        $locations =DB::table('levels')
                    ->select('lev_location as val')
                    ->where('cat_id','=',$cat_id)
                    ->get();
                    // ->select(DB::raw('order by lev_num ASC'))
                    // ->get();

        // dd($locations);
    //  Initialize the map with $config properties
        $gmap = new GMaps();
        $gmap->initialize($config);
        // dd($markerSet[0]);
        $i = 1;
        foreach($locations as $data){

            // echo $markerSet[2];

            $marker['position'] = $data->val;
            $marker['label']= $i;
            $gmap->add_marker($marker);
            $i++;

        }
        $gmap->add_polyline($polyline);
        // $map = $gmap->create_map();
        // Add marker to the map
        // $marker['position'] = 'USP Laucala Campus';
        // $marker['infowindow_content'] = 'USP Laucala Campus';
        // $marker['animation'] = 'DROP';

        // $gmap->add_marker($marker);
        // // $marker['position'] = '-18.150546624382894, 178.44396471977234';
        // // // $marker['draggable'] = true;
        // // $marker['infowindow_content'] = 'USP Book Center';
        // // $marker['animation'] = 'DROP';
        // // GMaps::add_marker($marker);
        // $marker['position'] = '-18.150546624382894,178.44396471977234';
        // $marker['infowindow_content'] = 'USP Book Center';
        // $gmap->add_marker($marker);

        // $marker['position'] = '-18.148344494198298,178.4457242488861';
        // $marker['infowindow_content'] = 'USP AusAid Lecture Theatre';
        // $gmap->add_marker($marker);

        // $marker['position'] = '-18.148419428235275,178.44379037618637';
        // $marker['infowindow_content'] = 'USP ICT Center Building';
        // $gmap->add_marker($marker);
        // // $latlngs = array("-18.149950216864134,178.44401836395264", "-18.14915908163672,178.44686150550842");
        // $gmap->isMarkerInsideGeofence($polygon, $latlngs);

        $map = $gmap->create_map();
        // $gmap = GMaps::create_map();

        // return view('map')->with('map', $map)->with('locations', $locations);
        return view('map')->with('map', $map);
    }
}
