<?php

namespace App\Http\Controllers;

use App\Models\Record;
use Illuminate\Http\Request;

class RecordController extends Controller
{
    public function index()
    {
        return Record::all();
    }

    public function store(Request $request)
    {
        $record = Record::create($request->all());
        return response()->json($record, 201);
    }

    public function show($id)
    {
        return Record::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $record = Record::findOrFail($id);
        $record->update($request->all());
        return response()->json($record, 200);
    }

    public function destroy($id)
    {
        Record::findOrFail($id)->delete();
        return response()->json(['message' => 'Record deleted successfully'], 200);
    }
}
