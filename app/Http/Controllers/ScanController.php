<?php

namespace App\Http\Controllers;

use App\Imports\DataImport;
use App\Imports\HeaderImport;
use App\Traits\FileStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ScanController extends Controller
{
    use FileStore;

    public function filter()
    {
        $files = Storage::files('public/data');
        $data = [];
        foreach ($files as $file) {
            $name = str_replace('public/data/', '', $file);
            $data[] = [
                'name' => $name,
                'path' => $name
            ];
        }
        $data = collect($data);
        return view('scans.filter', compact('data'));
    }

    public function code(Request $request)
    {
        $path = $request->path;
        // return view('scans.scan', compact('path'));
        return view('scans.scan_v2', compact('path'));
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $path = $request->path;
        $filePath = public_path("storage/data/".$path); 

        $data = Excel::toCollection(new DataImport, $filePath);

        $headers = $data[0][0];
        $data = $data[0];

        return view('scans.index', compact('headers', 'data', 'path'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('scans.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $path = $this->getPathFile($request->file('data'), 'data');
            $response = "Berhasil import data ke path : " . $path;
            return redirect()->route('scan.filter')->with('success', $response);
        } catch (\Throwable $th) {
            return back()->with('toast_error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getScanData(Request $request)
    {
        $path = $request->path;
        $filePath = public_path("storage/data/".$path); 
        if($request->code == null){
            return response()->json([]);
        }

        $data = Excel::toCollection(new DataImport, $filePath);
        $headers = $data[0][0];
        $data = $data[0];   
        $response = [];
        $found = false;
        foreach ($data as $key_item => $value) {
            if($key_item != 0){
                foreach($value as $item){
                    if($item == $request->code){
                        $found = true;
                    }
                }
                if($found == true){
                    foreach($value as $key => $item){
                        if($data[$key_item][$key] != null){
                            $response[] = [
                                'data' => $headers[$key],
                                'value' => $data[$key_item][$key]
                            ];
                        }
                    }
                    return response()->json($response);
                }
            }
        }
        return response()->json($response);
    }
}
