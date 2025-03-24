<?php

namespace App\Http\Controllers;

use Illuminate\Console\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;

class TableFetcher
{

    public function index(Request $request)
    {
        $tables = ['InventoryData', 'WorkmanData', 'EnrollmentData', 'PublicSchools', 'FacilityData'];
        $selectedTable = $request->input('selected_table', null);
        $selectedColumns = $request->input('selected_columns', []);
        $mergedTableData = $request->input('mergedTableData', []);
        $tableData = $request->input ('tableData', session( 'tableData', []));

        $columns = [];

        if (!empty($selectedTable) && in_array($selectedTable, $tables)) {
            $columns[$selectedTable] = DB::getSchemaBuilder()->getColumnListing($selectedTable);
        }

        return view('dTable',compact('tables', 'selectedTable', 'columns', 'selectedColumns', 'tableData', 'mergedTableData'));
    }


    public function createMergedTable(Request $request)
    {
        $selectedColumns = $request->input('selected_columns', []);

        // Retrieve session data (should now have stored data)
        $tableData = session('tableData', []);

        if (empty($selectedColumns)) {
            return back()->with('error', 'Please select at least one column.');
        }

        $mergedTableData = session('mergedTableData',[]);
        $ids = [];

        foreach ($selectedColumns as $column) {
            list($table, $colName) = explode('.', $column);
            if (!Schema::hasColumn($table, $colName)) {
                continue; // Skip invalid columns
            }

            $data = DB::table($table)->select('id', $colName)->orderBy('id')->get();
            foreach ($data as $row) {
                $ids[$row->id] = $row->id; // Collect all unique IDs
                $mergedTableData[$row->id][$colName] = $row->$colName;
            }
        }

        // Ensure every row has an ID column
        foreach ($ids as $id) {
            if (!isset($mergedTableData[$id])) {
                $mergedTableData[$id] = [];
            }
            $mergedTableData[$id]['id'] = $id;
        }


        return view('mTable', [
            'tables' => ['InventoryData', 'WorkmanData', 'EnrollmentData', 'PublicSchools', 'FacilityData'],
            'selectedColumns' => array_merge(['id'], $selectedColumns),
            'mergedTableData' => array_values($mergedTableData),
            'tableData' => $tableData
        ]);
    }

    #NEW FUNCTIONS

    public function updateTableScreen(Request $request)
    {
        $tables = ['InventoryData', 'WorkmanData', 'EnrollmentData', 'PublicSchools', 'FacilityData'];

        $selectedTable = $request->input('selected_table', null);

        $selectedColumns = $request->input('selected_columns', []);

        $mergedTableData = session('mergedTableData', []);

        $mergedTableData = $request->input('mergedTableData', []);

        $tableData = $request->input('tableData', session('tableData', []));

        $columns = [];

        $columnToDelete = $request->input('columnToDelete');

        $selectedColumns = $request->input('selected_columns', []);

        $mergedTableData = $request->input('mergedTableData', []);

        // Remove the column from the selectedColumns array
        if (($key = array_search($columnToDelete, $selectedColumns)) !== false) {

            unset($selectedColumns[$key]);

        }
        // Re-index selectedColumns array
        $selectedColumns = array_values($selectedColumns);

        // Remove the column from each row in mergedTableData
        foreach ($mergedTableData as &$row) {

            // Extract the actual column name from the string "TableName.columnName"
            $parts = explode('.', $columnToDelete);

            $colName = end($parts);

            if (isset($row[$colName])) {

                unset($row[$colName]);

            }

        }


        if (!empty($selectedTable) && in_array($selectedTable, $tables)) {

            $columns[$selectedTable] = DB::getSchemaBuilder()->getColumnListing($selectedTable);

        }


        return view('iTable', compact('tables', 'selectedTable', 'columns', 'selectedColumns', 'tableData', 'mergedTableData'));

    }


    public function mergeCurrentMaintTable(Request $request)
    {
        $mergedTableData = session('mergedTableData', []);

        $tables = ['InventoryData', 'WorkmanData', 'EnrollmentData', 'PublicSchools', 'FacilityData'];

        $selectedTable = $request->input('selected_table', null);

        $selectedColumns = $request->input('selected_columns', []);

        $mergedTableData = $request->input('mergedTableData', []);

        $tableData = $request->input('tableData', session('tableData', []));

        $columns = [];

        $groupedColumns = [];

        foreach ($selectedColumns as $col) {

            $parts = explode('.', $col);

            // Only handle "table.column" format
            if (count($parts) === 2) {

                $tableName = $parts[0];

                $columnName = $parts[1];

                $groupedColumns[$tableName][] = $columnName;

            }
        }

        // 2. For each table in $groupedColumns, fetch data for the valid columns and merge by 'id'.
        foreach ($groupedColumns as $tableName => $cols) {

            // Check if table is in our $tables list and actually exists
            if (in_array($tableName, $tables) && Schema::hasTable($tableName)) {

                // Get all real columns from this table
                $actualCols = DB::getSchemaBuilder()->getColumnListing($tableName);

                // Only keep columns that exist in the DB table
                $validCols = array_intersect($cols, $actualCols);

                if (!empty($validCols)) {

                    // Always include 'id' so we can merge by it
                    $colsToSelect = array_unique(array_merge(['id'], $validCols));

                    // Fetch the rows from this table
                    $rows = DB::table($tableName)->select($colsToSelect)->get();

                    // Merge these rows into $mergedTableData by matching 'id'
                    foreach ($rows as $r) {

                        $rArr = (array) $r;   // Convert object to array
                        $rowId = $rArr['id'] ?? null;

                        // Skip if there's no 'id' in this row
                        if ($rowId === null) {

                            continue;

                        }

                        // If this 'id' doesn't exist yet, initialize it
                        if (!isset($mergedTableData[$rowId])) {

                            $mergedTableData[$rowId] = [];

                        }

                        // Merge each valid column's data
                        foreach ($validCols as $vc) {

                            $mergedTableData[$rowId][$vc] = $rArr[$vc] ?? '';

                        }
                    }
                }
            }
        }

        return view('iTable', compact('tables', 'selectedTable', 'columns', 'selectedColumns', 'tableData', 'mergedTableData'));

    }


}
