<?php

namespace App\Http\Controllers;

// use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\patients;
use App\Models\islands;
use App\Models\address;

class PatientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function patientsDetail()
    {
        // return patients::all();
        // return address::all();
        // return islands::all();
        return  patients::select('*','patients.id')
        ->join('addresses', 'addresses.id', '=', 'patients.address')
        ->join('islands', 'islands.id', '=', 'patients.island')
        ->get();
    }
    public function addressesDetail()
    {
        return address::all();
    }
    public function islandsDetail()
    {
        return islands::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 
        $patientIsland = $request->validate([
            'islandName' => 'required|string',
            'atoll' => 'required|string',
            'country' => 'required|string'
        ]);
        $patientAddress = $request->validate([
            'floor' => 'required|string',
            'houseName' => 'required|string',
            'street' => 'required|string',
            'postCode' =>'integer'
        ]);
        //checking if the island exists in the database
        if(islands::where('islandName',$patientIsland['islandName'])->exists()){
            $island = islands::where('islandName',$patientIsland['islandName'])->first();
        }else{
            $island = islands::create([
                'islandName' => $patientIsland['islandName'],
                'atoll' => $patientIsland['atoll'],
                'country' => $patientIsland['country']
            ]);
            $island->save();
        }
        // checking if db have Floor and Address both matching in a row
        if(address::where('floor',$patientAddress['floor'])->where('houseName', $patientAddress['houseName'])->exists()){
            $address = address::where('floor',$patientAddress['floor'])->where('houseName', $patientAddress['houseName'])->first();         
        }else{
            $address = address::create([
                'floor' => $patientAddress['floor'],
                'houseName' => $patientAddress['houseName'],
                'street' => $patientAddress['street'],
                'postCode' => $patientAddress['postCode']
            ]);
            $address->save();
        }

        $patientInfo = $request->validate([
            'fullName' => 'required|string',
            'DOB' => 'required',
            'nationalID' => 'required|string',
        ]);
        $patient = patients::create([
            'fullName' => $patientInfo['fullName'],
            'DOB' => $patientInfo['DOB'],
            'nationalID' => $patientInfo['nationalID'],
            'island' => $island->id,
            'address' => $address->id,

        ])->save();

        return $patient;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
