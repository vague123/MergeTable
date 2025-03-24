<?php

namespace App\Models;
use App\Http\Controllers\TableFetcher;
use Illuminate\Database\Eloquent\Model;

class PublicSchools extends Model
{
    protected $fillable = ['School_ID','School_Name','Location'];
}
