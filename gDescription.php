<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class gDescription
{

    public function show(){
        return view('MainTable');
    }

    public function main(Request $request)
    {
        // Validate input
        $validatedData = $request->validate([
            'Table_Title' => 'required|string|max:30',
            'dTable' => 'required|string|max:1000',
        ]);

        // Store data permanently in the session
        session(['tableData' => $validatedData]);

        // Redirect to another page
        return redirect()->route('get.columns');
    }



}
