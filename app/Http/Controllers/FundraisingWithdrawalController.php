<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFundraisingWithdrawalRequest;
use App\Http\Requests\UpdateFundraisingWithdrawalRequest;
use App\Models\Fundraiser;
use App\Models\Fundraising;
use App\Models\FundraisingWithdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FundraisingWithdrawalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $fundraising_withdrawals = FundraisingWithdrawal::orderByDesc('id')->get();
        return view('admin.fundraising_withdrawals.index', compact('fundraising_withdrawals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFundraisingWithdrawalRequest $request, Fundraising $fundraising)
    {
        //

        $hasRequestedWithdrawal = $fundraising->withdrawals()->exists();

        if ($hasRequestedWithdrawal) {
            return redirect()->route('admin.fundraisings.show', $fundraising);
        }

        DB::transaction(function () use ($request, $fundraising) {
            $validated = $request->validated();

            $withdrawal = new FundraisingWithdrawal();
            $withdrawal->bank_name = $validated['bank_name'];
            $withdrawal->bank_account_name = $validated['bank_account_name'];
            $withdrawal->bank_account_number = $validated['bank_account_number'];
            $withdrawal->fundraiser_id = Auth::user()->fundraisers->id;
            $withdrawal->has_received = false;
            $withdrawal->has_sent = false;
            $withdrawal->amount_requested = $fundraising->totalReachedAmount();
            $withdrawal->amount_received = 0;
            $withdrawal->proof = 'proofs/buktitransferpalsu.png';
            $withdrawal->fundraising_id = $request->fundraising_id;  // Menggunakan $fundraising dari parameter


            $withdrawal->save();
        });

        return redirect()->route('admin.my-withdrawals');
    }

    /**
     * Display the specified resource.
     */
    public function show(FundraisingWithdrawal $fundraisingWithdrawal)
    {
        //
        return view('admin.fundraising_withdrawals.show', compact('fundraisingWithdrawal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FundraisingWithdrawal $fundraisingWithdrawal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFundraisingWithdrawalRequest $request, FundraisingWithdrawal $fundraisingWithdrawal)
    {
        //
        DB::transaction(function () use ($request, $fundraisingWithdrawal) {
            $validated = $request->validated();
            if ($request->has('proof')) {
                $proofPath = $request->file('proof')->store('proofs', 'public');
                $validated['proof'] = $proofPath;
            }

            $validated['has_sent'] = 1;

            $fundraisingWithdrawal->update($validated);
        });

        return redirect()->route('admin.fundraising_withdrawals.show', $fundraisingWithdrawal);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FundraisingWithdrawal $fundraisingWithdrawal)
    {
        //
    }
}
