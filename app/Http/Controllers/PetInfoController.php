<?php

namespace App\Http\Controllers;

use App\Models\PetInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PetInfoController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'email' => 'required',
            'pup-name' => 'required',
            'pup-gender' => 'required',
            'have-allergies' => 'required',
            'birthdate' => 'required',
            'breed' => 'required',
            'weight' => 'required',
            'lifestyle' => 'required',
            'goal' => 'required',
        ]);

        if($request->file('image-file')){
            $uploadedFile = $request->file('image-file');
            $filename = time()."-".$uploadedFile->getClientOriginalName();
            $filePath = $uploadedFile->storeAs('uploads', $filename, 'public');
        }

        $newPet = PetInfo::create([
            'owner_email' => $request->email,
            'pet_name' => $request['pup-name'],
            'photo' => !empty($filePath) ? $filePath : null,
            'gender' => $request['pup-gender'],
            'is_spayed' => $request->spayed,
            'is_pregnant' => $request->pregnant,
            'is_neutered' => $request->neutered,
            'have_allergies' => $request['have-allergies'],
            'allergies' => $request->allergies,
            'other_allergies' => $request['other-allergy'],
            'birthdate' => $request->birthdate,
            'breed' => $request->breed,
            'weight' => $request->weight,
            'ideal_weight' => $request['ideal-weight'],
            'lifestyle' => $request->lifestyle,
            'goal' => $request->goal
        ]);

        return redirect()->route('successful-pet-creation', ['pet_id' => $newPet->id]);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pet = PetInfo::find($id);

        if($pet->delete()){
            $message = $pet->pet_name.' was successfully removed.';
        }else{
            $message = "An error occurred while trying to remove ".$pet->pet_name;
        }

        session()->flash('message', $message);

        return back();
    }
}
