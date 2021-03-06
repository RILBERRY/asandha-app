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
        return  patients::select('*','patients.id')
        ->join('addresses', 'addresses.id', '=', 'patients.address')
        ->join('islands', 'islands.id', '=', 'patients.island')
        ->orderBy('patients.id','ASC')
        ->get();
    }
    public function PatientInfo(){
        return patients::all("fullName","nationalID");
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
    public function patient(Request $request)
    {
        $patientInfo = $request->validate([
            'fullName' => 'required|string',
            'DOB' => 'required',
            'nationalID' => 'required|string',
        ]);

        $island = $this->CreateNewIsland($request);
        $address = $this->CreateNewAddress($request);
        if(patients::where('nationalID',$patientInfo['nationalID'])->exists()){
            $patient = patients::where('nationalID',$patientInfo['nationalID'])->first();
            $msg = "Patient exists";
        }else{
            $patient = patients::create([
                'fullName' => $patientInfo['fullName'],
                'DOB' => $patientInfo['DOB'],
                'nationalID' => $patientInfo['nationalID'],
                'island' => $island['island']->id,
                'address' => $address['address']->id,
                
            ]);
            $patient->save();
            $msg = "Patient Created Successfully";
        }

        return ['patient' => $patient, 'msg' => $msg];
    }
    
    public function island(Request $request){
        $island = $this->CreateNewIsland($request);
        return $island;
    }

    public function address(Request $request){
        $address = $this->CreateNewAddress($request);
        return $address;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showPatient($id)
    {
        return patients::find($id);
    }
    public function showAddress($id)
    {
        return address::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delAddress(Request $request, $id)
    {
        try {
            $msg = address::destroy($id);
        }
        catch (Exception ){
            return ['msg'=>"Delete failed! Patient with this Address exists"];
        }
        $msg = "Address Deleted ";
        return ['msg'=>$msg];
    }
    public function delPatient(Request $request, $id)
    {
        try{
            $msg = patients::destroy($id);
        }
        catch (Exception ){
            return ['msg'=>"Delete failed! Contact Tech Support"];
        }
        $msg = "Patient Deleted ";

        return ['msg'=>$msg];
    }

    public function UpdateAddress(Request $request, $id)
    {
        try {
            $Address = address::find($id);
            $Address->update($request->all());
        }
        catch (Exception ){
            return ['msg'=>"Update failed! Try again"];
        }
        $msg = "Address Updated ";
        return ['msg'=>$msg];
    }
    public function UpdatePatient(Request $request, $id)
    {
        try{
            $Patient = patients::select('*','patients.id')
            ->join('addresses', 'addresses.id', '=', 'patients.address')
            ->join('islands', 'islands.id', '=', 'patients.island')
            ->find($id);
            if($Patient->street != $request->street || $Patient->houseName != $request->houseName){ 
                $res = $this->CreateNewAddress($request);
                // dd($res['msg']);
                if($res['msg'] == 'Island Exists'){
                    $res['address']->update($request->all());
                }
                else{
                    $Patient->update([
                        'address' => $res['address']->id
                    ]);
                }
            }
            if($Patient->atoll != $request->atoll || $Patient->islandName != $request->islandName){ 
                $res = $this->CreateNewIsland($request);
                // dd($res['msg']);
                if($res['msg'] == 'Island Exists'){
                    $res['island']->update($request->all());
                }
                else{
                    $Patient->update([
                        'island' => $res['island']->id
                    ]);
                }
            }
            $Patient->update($request->all());
            $msg = "Patient details updated";
            return ['Patient' => $Patient, 'msg' => $msg];
        }
        catch (Exception ){
            return ['msg'=>"Update failed! Try again"];
        }
    }

    private function CreateNewAddress($request){
        $patientAddress = $request->validate([
            'floor' => 'required|string',
            'houseName' => 'required|string',
            'street' => 'required|string',
            'postCode' =>'integer'
        ]);
        if(address::where('floor',$patientAddress['floor'])->where('houseName', $patientAddress['houseName'])->exists()){
            $address = address::where('floor',$patientAddress['floor'])->where('houseName', $patientAddress['houseName'])->first();         
            $msg = "Address Exists";
        }else{
            $address = address::create([
                'floor' => $patientAddress['floor'],
                'houseName' => $patientAddress['houseName'],
                'street' => $patientAddress['street'],
                'postCode' => $patientAddress['postCode']
            ]);
            $address->save();
            $msg = "Address Created Successfully";
        }
        return ['address' => $address, 'msg' => $msg];
    }

    private function CreateNewIsland($request){
        $patientIsland = $request->validate([
            'islandName' => 'required|string',
            'atoll' => 'required|string',
            'country' => 'required|string'
        ]);
        if(islands::where('islandName',$patientIsland['islandName'])->exists()){
            $island = islands::where('islandName',$patientIsland['islandName'])->first();
            $msg = "Island Exists";
        }else{
            $island = islands::create([
                'islandName' => $patientIsland['islandName'],
                'atoll' => $patientIsland['atoll'],
                'country' => $patientIsland['country']
            ]);
            $island->save();
            $msg = "Island Created Successfully";
        }
        return ['island' => $island, 'msg' => $msg];
    }
    
    

}
