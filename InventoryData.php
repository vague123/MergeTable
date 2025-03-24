<?php

namespace App\Models;
use App\Http\Controllers\TableFetcher;
use Illuminate\Database\Eloquent\Model;

class InventoryData extends Model
{
    protected $fillable = ['Fund_Year','Category','Serial_Number','Location','Cost_Of_Equipment'];

}
