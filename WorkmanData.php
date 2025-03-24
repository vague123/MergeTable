<?php

namespace App\Models;
use App\Http\Controllers\TableFetcher;
use Illuminate\Database\Eloquent\Model;

class WorkmanData extends Model
{
    protected $fillable = ['Worker_Name','Position','Contact_Number','Email','Registration_Number'];

}
