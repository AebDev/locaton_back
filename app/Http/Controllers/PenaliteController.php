<?php

namespace App\Http\Controllers;

use App\Penalite;
use Illuminate\Http\Request;

class PenaliteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penalite = Penalite::all();
        return response()->json(['data' => $penalite], 200);
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
        $penalite = Penalite::create($request->all());

        return response()->json([
            'success' => true,
            'data' => $penalite
        ], '201');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Penalite  $penalite
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $penalite = Penalite::find($id);

        if ($penalite === null) {

            return response()->json([
                'success' => false,
                'data' => 'item not found'
            ], '404');
        }

        return response()->json([
            'success' => true,
            'data' => $penalite
        ], '200');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Penalite  $penalite
     * @return \Illuminate\Http\Response
     */
    public function edit(Penalite $penalite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Penalite  $penalite
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $penalite = Penalite::find($id);

        if ($penalite === null) {

            return response()->json([
                'success' => false,
                'data' => 'item not found'
            ], '404');
        }

        $penalite->update($request->all());

        return response()->json([
            'success' => true,
            'data' => $penalite
        ], '202');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Penalite  $penalite
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $penalite = Penalite::find($id);

        if ($penalite === null) {

            return response()->json([
                'success' => false,
                'data' => 'item not found'
            ], '404');
        }

        $penalite->delete();

        return response()->json([
            'success' => true,
            'data' => null
        ], '200');
    }
}
