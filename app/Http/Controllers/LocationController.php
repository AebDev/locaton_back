<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\Location;
use App\Vehicule;
use App\Categorie;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $locations = Location::with('vehicules')->where('user_id',$user->id)->get();
        return response()->json(['data' => $locations], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $location = new Location();
        $location->montant = $request->montant;
        $location->etat = $request->etat;
        $location->num_de_vol = $request->num_de_vol;
        $location->compagnie_aerienne = $request->compagnie_aerienne;
        $location->date_debut = $request->date_debut;
        $location->date_fin = $request->date_fin;
        $location->type_de_protection = $request->type_de_protection;
        $location->option_gps = $request->option_gps;
        $location->option_wifi = $request->option_wifi;
        $location->option_Rehausseur_enfant = $request->option_Rehausseur_enfant;
        $location->option_Rehausseur_bebe = $request->option_Rehausseur_bebe;
        $location->user_id = $user->id;
        $location->vehicule_id = $request->vehicule_id;
        $location->save();

        // $datetime1 = new DateTime($request->date_fin);
        // $datetime2 = new DateTime($request->date_debut);

        // $interval = $datetime1->diff($datetime2);

        $location = Location::create(array_merge($request->all(), ['user_id' => $user->id]));

        return response()->json([
            'success' => true,
            'data' => $location
        ], '201');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $location = Location::find($id);

        if ($location === null) {

            return response()->json([
                'success' => false,
                'data' => 'item not found'
            ], '404');
        }
        $vehicule = Vehicule::find($location->vehicule_id);

        return response()->json([
            'success' => true,
            'data' => $location, $vehicule
        ], '200');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $location = Location::find($id);

        if ($location === null) {

            return response()->json([
                'success' => false,
                'data' => 'item not found'
            ], '404');
        }

        $location->update($request->all());

        return response()->json([
            'success' => true,
            'data' => $location
        ], '202');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $location = Location::find($id);

        if ($location === null) {

            return response()->json([
                'success' => false,
                'data' => 'item not found'
            ], '404');
        }

        $location->delete();

        return response()->json([
            'success' => true,
            'data' => null
        ], '200');
    }

    public function reservations()
    {
        // if (JWTAuth::parseToken()->authenticate()->role !== 'admin') {
        //     return response()->json(['you should be admin'], 400);
        // }

        $locations = Location::with('users')->with('vehicules')->get();
        return response()->json(['data' => $locations], 200);
    }

    public function deleteLocations(Request $request)
    {
        foreach ($request->deleteList as $id) {

            $user = Location::find($id);

            if($user !== null){
                $user->delete();
            } 
        }
        
        return response()->json([
            'success' => true,
            'data' => null
        ],'200');
    }
}
