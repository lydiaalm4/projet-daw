<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class user extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->tokenCan('Admin')){
            return response()->json(\App\Models\User::all());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {
            $validateuser = Validator::make($request->all(),
                [
                    'email' => 'required',
                    'password' => 'required',
                ]
            );

            if ($validateuser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateuser->errors()
                ],401);
            }

            $user = \App\Models\User::create([
                'name' => $request->name ,
                'firstname'=> $request->firstname,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'domaine'=> $request->domaine,
                'photo' => $request->photo,
                'type'=> $request->type,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User created Succesfully',
                'token' => $user->createToken('API TOKEN')->plainTextToken
            ], 200);
        } catch (\Throwable $th) {
            // Return Json Response
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update (Request $request)
    {
            $user = $request->user();
            $user->update($request->all());
            $user = $user->refresh();
            return response()->json([
                'status' => 'Good',
                'message' => 'Update Successful'
            ]) ;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function display_project()
    {
        if (auth()->user()->tokenCan('Admin','Teacher','Student')) {
            return response()->json(project::all());
        }
    }
}
