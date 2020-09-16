<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Drug;

class DrugController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $drugs = Drug::all();
        return view('inventory.drugs_all', ['drugs' => $drugs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventory.drug_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:drugs', 
            'description' => 'required',
            'price' => 'required|numeric'
        ]);

        Drug::create($data);
        return redirect(route('drugs.index'))->with('success', 'added to inventory list');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Drug $drug)
    {
        return view('inventory.drug_details', ['drug' => $drug]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Drug $drug)
    {
        return view('inventory.drug_edit', ['drug' => $drug]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Drug $drug)
    {
        $data = $request->validate([
            'name' => 'required', 
            'description' => 'required',
            'price' => 'required|numeric'
        ]);
        
        $searchDrug = Drug::where(['name' => $data['name']])->first();

        if ($searchDrug->id != $drug->id)
        {
            return redirect(route('drugs.show', ['drug' => $drug->id]))
                ->with('error', 'Drug with that name already exists.');
        }
        $drug->update($data);
        return redirect(route('drugs.index'))->with('success', 'Updated drug details successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Drug $drug)
    {
        $drug->delete();
        return redirect(route('drugs.index'))->with('success', 'Removed drug from inventory');
    }
}
