<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFundraisingRequest;
use App\Http\Requests\UpdateFundraisingRequest;
use App\Models\Category;
use App\Models\Fundraiser;
use App\Models\Fundraising;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FundraisingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $user = Auth::user();

        $fundraisingQuery = Fundraising::with(['category', 'fundraiser', 'donaturs'])->orderByDesc('id');

        if ($user->hasRole('fundraiser')) {
            $fundraisingQuery->whereHas('fundraiser', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });
        }

        $fundraisings = $fundraisingQuery->paginate(10);

        return view('admin.fundraisings.index', compact('fundraisings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categories = Category::all();
        return view('admin.fundraisings.create', compact('categories'));
    }

    public function activate_fundraising(Fundraising $fundraising)
    {
        $fundraising->update([
            'status' => 'active',
        ]);

        return redirect()->route('admin.fundraisings.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFundraisingRequest $request)
    {
        //
        $fundraiser = Fundraiser::where('user_id', Auth::user()->id)->first();

        DB::transaction(function () use ($request, $fundraiser) {
            $validated = $request->validated();

            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
                $validated['thumbnail'] = $thumbnailPath;
            }
            $validated['slug'] = Str::slug($validated['name']);

            $validated['fundraiser_id'] = $fundraiser->id;
            $validated['is_active'] = false;
            $validated['has_finished'] = false;

            $fundraising = Fundraising::create($validated);
        });

        return redirect()->route('admin.fundraisings.index')->with('success', 'Fundraising created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Fundraising $fundraising)
    {
        //
        $totalDonations = $fundraising->totalReachedAmount();
        $goalReached = $totalDonations >= $fundraising->target_amount;

        $percentage = ($totalDonations / $fundraising->target_amount) * 100;
        if ($percentage > 100) {
            $percentage = 100;
        }

        return view('admin.fundraisings.show', compact('fundraising', 'goalReached', 'percentage', 'totalDonations'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fundraising $fundraising)
    {
        //
        $categories = Category::all();
        return view('admin.fundraisings.edit', compact('fundraising', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFundraisingRequest $request, Fundraising $fundraising)
    {
        //
        DB::transaction(function () use ($request, $fundraising) {
            $validated = $request->validated();

            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
                $validated['thumbnail'] = $thumbnailPath;
            }

            $validated['slug'] = Str::slug($validated['name']);

            $fundraising->update($validated);
        });

        // Perbarui nilai $totalDonations setelah pembaruan data Fundraising dilakukan
        $totalDonations = $fundraising->totalReachedAmount();
        $goalReached = $totalDonations >= $fundraising->target_amount;

        $percentage = ($totalDonations / $fundraising->target_amount) * 100;
        if ($percentage > 100) {
            $percentage = 100;
        }

        return view('admin.fundraisings.show', compact('fundraising', 'totalDonations', 'goalReached', 'percentage'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fundraising $fundraising)
    {
        //
        DB::beginTransaction();

        try {
            $fundraising->delete();

            DB::commit();

            return redirect()->route('admin.fundraisings.index')->with('success', 'Category deleted successfully');
        } catch (\Exception $e) {
            //throw $th;
            DB::rollBack();
            return redirect()->route('admin.fundraisings.index')->with('error', 'Category failed to delete');
        }
    }
}
