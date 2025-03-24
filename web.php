<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\gDescription;
use App\Http\Controllers\TableFetcher;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DemoController;
use Laravel\Prompts\Table;

/*
Route::get('/download-csv', [DemoController::class, 'downloadCSV'])->name('download.csv');
*/

Route::match(['get', 'post'], '/Login', [LoginController::class, 'Login'])->name('mylogin');
// Get title and description for the table
Route::match(['get','post'], '/Panel', [gDescription::class, 'show'])->name('panelShow');
// Restoring the data into a table
Route::match(['get','post'], '/PanelFetch', [gDescription::class, 'main'])->name('panelFetcher');
// Fetch available tables
Route::match(['get', 'post'], '/Panel1', [TableFetcher::class, 'index'])->name('get.columns');
// Create merged table dynamically
Route::match(['get', 'post'],'/Panel2', [TableFetcher::class, 'createMergedTable'])->name('create.merged.table');
// NOTE Dont forget to change in .env change to DB_DATABASE=laraveldatabase
Route::match(['get', 'post'],'/Panel3', [TableFetcher::class, 'updateTableScreen'])->name('get.columns2');
// NOTE you will be sent into another page to merge in another  batch of tables and columns
Route::match(['get', 'post'],'/Panel4', [TableFetcher::class, 'mergeCurrentMaintTable'])->name('get.columns3');
//Delete columns
Route::post('/delete-column', [TableFetcher::class, 'updateTableScreen'])->name('delete.column');
//calculate columns
//Route::post('/calculate-columns', [TableFetcher::class, 'calculateColumns'])->name('calculate-columns');
