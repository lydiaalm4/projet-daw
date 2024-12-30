<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class utilisateur extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(utilisateur::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(utilisateur $request)
    {
//        $request->v([
//            'name' => 'required'
//        ]);
        $nam = $request->name ;
        $fnam = $request->firstName ;
        $email = $request->email ;
        $password = $request->password ;
        $phone = $request->phone ;
        $photo = $request->photo ;
        $domaine = $request->domaine ;
        utilisateur::create([
            'name' => $nam ,
            'firstName'=> $fnam,
            'email' => $email,
            'password' => $password,
            'phone' => $phone,
            'photo' => $photo,
            'domaine'=> $domaine
        ]);
        return 'Good ';
    }

    /**
     * Display the specified resource.
     */
    public function show(utilisateur $utilisateur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(utilisateur $utilisateur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, utilisateur $utilisateur)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(utilisateur $utilisateur)
    {
        //
    }
}
