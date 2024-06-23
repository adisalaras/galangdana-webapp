<?php

namespace App\Http\Controllers;

use App\Models\Fundraising;
use Illuminate\Http\Request;

class FundraisingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function activate_fundraising(Fundraising $fundraising)
    {
        $fundraising->update([
            'status' => 'active'
        ]);

        return redirect()->route('admin.fundraisings.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Fundraising $fundraising)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fundraising $fundraising)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fundraising $fundraising)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fundraising $fundraising)
    {
        //
    }
}
