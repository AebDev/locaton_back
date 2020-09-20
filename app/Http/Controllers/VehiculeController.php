<?php

namespace App\Http\Controllers;

use App\Location;
use App\Vehicule;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class VehiculeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       
        $age = $request->age;
        $from = $request->start;
        $to = $request->end;

        $vehicules = Vehicule::with(['categories' => function ($q) use ($age) {
            $q->where('age_min', '<=', $age);
        }])
            ->whereNotIn('vehicules.id', function ($query) use ($from, $to) {

                $query->select('vehicule_id')
                    ->from('locations')
                    ->where(function ($q) use ($from, $to) {
                        $q->where('date_debut', '<', $from)
                            ->where('date_debut', '<', $to)
                            ->where('date_fin', '>', $from)
                            ->where('date_fin', '>', $to);
                    })
                    ->orWhere(function ($q) use ($from, $to) {
                        $q->where('date_debut', '>', $from)
                            ->where('date_debut', '<', $to);
                    })
                    ->orWhere(function ($q) use ($from, $to) {
                        $q->where('date_fin', '>', $from)
                            ->where('date_fin', '<', $to);
                    });
            })->get();



        // $reservation = Location::where(function ($q) use ($from, $to) {
        //     $q->where('date_debut', '<', $from)
        //         ->where('date_debut', '<', $to)
        //         ->where('date_fin', '>', $from)
        //         ->where('date_fin', '>', $to);
        // })
        //     ->orWhere(function ($q) use ($from, $to) {
        //         $q->where('date_debut', '>', $from)
        //             ->where('date_debut', '<', $to);
        //     })
        //     ->orWhere(function ($q) use ($from, $to) {
        //         $q->where('date_fin', '>', $from)
        //             ->where('date_fin', '<', $to);
        //     })->get();

        // $vehicules = Vehicule::join('categories','categories.id','vehicules.categorie_id')
        //                     ->where('age_min','<=',$age)
        //                     ->whereNotIn('vehicules.id',function($query) use ($from,$to) {

        //                         $query->select('vehicule_id')
        //                             ->from('locations')
        //                             ->where(function($q) use ($from,$to) {
        //                                 $q->whereBetween('date_debut', [$from, $to])
        //                                 ->orWhereBetween('date_fin', [$from, $to]);
        //                             });


        //                      })->get();


        // $vehicules = Vehicule::with(['categories' => function($query) use ($age){
        //     $query->where('age_min','<=',$age);
        // }])->get();



        return response()->json([
            'success' => true,
            'data' => $vehicules
        ], '200');
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
       
        $file = $request->file('image'); 
         
         $ext = $file->extension();
         
         $fileName = Carbon::now()->format('d-m-Y') . '-' . Str::random(10) . '.' . $ext;
         
         $request->file('image')->move(public_path("img/vehicule"), $fileName); 


        $vehicule = new Vehicule();
        $vehicule->matricule = $request->matricule;
        $vehicule->marque = $request->marque;
        $vehicule->modele = $request->modele;
        $vehicule->image = '/img/vehicule/' . $fileName;
        $vehicule->couleur = $request->couleur;
        $vehicule->carburant = $request->carburant;
        $vehicule->cout_par_jour = $request->cout_par_jour;
        $vehicule->nb_places = $request->nb_places;
        $vehicule->nb_portes = $request->nb_portes;
        $vehicule->climatisation = $request->climatisation;
        $vehicule->boite_vitesse = $request->boite_vitesse;
        $vehicule->franchise = $request->franchise;
        $vehicule->categorie_id = $request->categorie_id;
        $vehicule->save();
        return response()->json([
            'success' => true,
            'data' => $vehicule
        ], '201');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Vehicule  $vehicule
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vehicule = Vehicule::find($id);
        return response()->json([
            'success' => true,
            'data' => $vehicule
        ], '200');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vehicule  $vehicule
     * @return \Illuminate\Http\Response
     */
    public function edit(Vehicule $vehicule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vehicule  $vehicule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $file = $request->file('image'); 
        
         $ext = $file->extension();
         $fileName = Carbon::now()->format('d-m-Y') . '-' . Str::random(10) . '.' . $ext;
         $request->file('image')->move(public_path("img/vehicule"), $fileName);


        $vehicule = Vehicule::find($id);
        $vehicule->update([
            'matricule' => $request->matricule,
            '$vehicule->marque' => $request->marque,
            'modele' => $request->modele,
            'image' => '/img/vehicule/' . $fileName,
            'couleur' => $request->couleur,
            'puissance' => $request->puissance,
            'cout_par_jour' => $request->cout_par_jour,
            'nb_places' => $request->nb_places,
            'nb_portes' => $request->nb_portes,
            'climatisation' => $request->climatisation,
            'boite_vitesse' => $request->boite_vitesse,
            'franchise' => $request->franchise,
            'categorie_id' => $request->categorie_id,
        ]);
        return response()->json([
            'success' => true,
            'data' => $vehicule
        ], '200');
    }

    public function updateVehicule(Request $request, $id)
    {
        $file = $request->file('image'); 
        
         $ext = $file->extension();
         $fileName = Carbon::now()->format('d-m-Y') . '-' . Str::random(10) . '.' . $ext;
         $request->file('image')->move(public_path("img/vehicule"), $fileName);


        $vehicule = Vehicule::find($id);
        $vehicule->update([
            'matricule' => $request->matricule,
            '$vehicule->marque' => $request->marque,
            'modele' => $request->modele,
            'image' => '/img/vehicule/' . $fileName,
            'couleur' => $request->couleur,
            'puissance' => $request->puissance,
            'cout_par_jour' => $request->cout_par_jour,
            'nb_places' => $request->nb_places,
            'nb_portes' => $request->nb_portes,
            'climatisation' => $request->climatisation,
            'boite_vitesse' => $request->boite_vitesse,
            'franchise' => $request->franchise,
            'categorie_id' => $request->categorie_id,
        ]);
        return response()->json([
            'success' => true,
            'data' => $vehicule
        ], '200');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vehicule  $vehicule
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vehicule = Vehicule::find($id);

        if ($vehicule === null) {
            return response()->json([
                'success' => false,
                'data' => 'item not found'
            ], '404');
        }
        $vehicule->delete();
        return response()->json([
            'success' => true,
            'data' => null
        ], '200');
    }

    public function vehicules()
    {
        // if (JWTAuth::parseToken()->authenticate()->role !== 'admin') {
        //     return response()->json(['you should be admin'], 400);
        // }

        $vehicules = Vehicule::with('categories')->get();
        return response()->json(['data' => $vehicules], 200);
    }

    public function deleteVehicules(Request $request)
    {
        foreach ($request->deleteList as $id) {

            $user = Vehicule::find($id);

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
