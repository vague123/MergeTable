<?php

namespace App\Models;
use App\Http\Controllers\TableFetcher;
use Illuminate\Database\Eloquent\Model;

class FacilityData extends Model
{
    protected $fillable = ['School_ID','Number_of_Classroom','Number_of_Faculty'];

}
