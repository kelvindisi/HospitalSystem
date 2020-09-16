<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Test;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('inventory.test_all', ['tests'=>Test::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventory.test_create');
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
            'name' => 'required|unique:tests',
            'description' => 'required',
            'charge' => 'required|numeric'
        ]);
        Test::create($data);

        return redirect(route('tests.index'))->with('success', 'Saved test details successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Test $test)
    {
        return view('inventory.test_details', ['test' => $test]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Test $test)
    {
        return view('inventory.test_edit', ['test' => $test]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Test $test)
    {
        $data = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'charge' => 'required|numeric'
        ]);

        $searched = Test::where(['name' => $data['name']])->first();
        if ($searched->id != $test->id)
        {
            return redirect(route('tests.edit', ['test'=> $test]))
                ->with('error', 'Test with that name already exist');
        }
        $test->update($data);

        return redirect(route('tests.index'))->with('success', 'Updated test details successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Test $test)
    {
        $test->delete();

        return redirect(route('tests.index'))->with('success', 'Removed test details from list.');
    }
}
