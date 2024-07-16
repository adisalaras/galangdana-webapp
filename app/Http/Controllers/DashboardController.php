<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Donatur;
use App\Models\Fundraiser;
use App\Models\Fundraising;
use App\Models\FundraisingWithdrawal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //
    public function apply_fundraiser()
    {
        $user = Auth::user();

        DB::transaction(function () use ($user) {
            $validated['user_id'] = $user->id;
            $validated['is_active'] = false;

            Fundraiser::create($validated);
        });

        return redirect()->route('admin.fundraisers.index');
        // return view('admin.fundraisers.index');
    }

    public function my_withdrawals()
    {
        $user = Auth::user();

        $fundraiserId = $user->fundraisers->id;

        $withdrawals = FundraisingWithdrawal::where('fundraiser_id', $fundraiserId)->orderByDesc('id')->get();

        return view('admin.my_withdrawals.index', compact('withdrawals'));
    }

    public function my_withdrawal_details(FundraisingWithdrawal $fundraisingWithdrawal)
    {
        return view('admin.my_withdrawals.details', compact('fundraisingWithdrawal'));
    }

    public function index()
    {
        $user = Auth::user();

        $fundraisingsQuery = Fundraising::query();
        $withdrawalQuery = FundraisingWithdrawal::query();

        if ($user->hasRole('fundraiser')) {
            $fundraiserId = $user->fundraisers->id;

            $fundraisingsQuery->where('fundraiser_id', $fundraiserId);
            $withdrawalQuery->where('fundraiser_id', $fundraiserId);

            $fundraisingIds = $fundraisingsQuery->pluck('id');

            $donaturs = Donatur::whereIn('fundraising_id', $fundraisingIds)->where('is_paid', true)->count();
        } else {
            $donaturs = Donatur::where('is_paid', true)->count();
        }

        $fundraisings = $fundraisingsQuery->count();
        $withdrawals = $withdrawalQuery->count();
        $categories = Category::count();
        $fundraisers = Fundraiser::count();

        return view('dashboard', compact('fundraisings', 'donaturs', 'withdrawals', 'categories', 'fundraisers'));
    }
}
