<?php

namespace App\Models;
use App\Http\Controllers\TableFetcher;
use Illuminate\Database\Eloquent\Model;

class EnrollmentData extends Model
{
    protected $fillable = ['Student_Name','Age','Sex','Address','Religion'];

}
