<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetInfo extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pet_info';

    protected $fillable = [
        'owner_email',
        'pet_name',
        'photo',
        'gender',
        'is_spayed',
        'is_neutered',
        'is_pregnant',
        'have_allergies',
        'allergies',
        'other_allergies',
        'birthdate',
        'breed',
        'weight',
        'ideal_weight',
        'lifestyle',
        'goal'
    ];
}
