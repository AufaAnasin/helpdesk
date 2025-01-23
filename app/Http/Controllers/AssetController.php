<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use Illuminate\Support\Facades\Log;

class AssetController extends Controller
{
    // for Register the Assets
    public function store(Request $request)
    {
        try {
            // Validate input data
            $validated = $request->validate([
                'asset_type' => 'required|string',
                'brand' => 'required|string',
                'product_name' => 'required|string',
                'product_number' => 'required|string',
                'date_purchased' => 'required|date',
                'price' => 'required|numeric',
                'notes' => 'nullable|string',
                'person_in_charge' => 'required|string',
                'hardware_location' => 'nullable|string',
                'is_borrowable' => 'nullable|boolean',
                'status' => 'Not Defined',
                'uploaded_files.*' => 'nullable|file|max:30720|mimes:jpg,png,pdf',
            ]);

            // Handle file uploads if files are present
            if ($request->hasFile('uploaded_files')) {
                // Check if any uploaded file exceeds the size limit (30MB)
                foreach ($request->file('uploaded_files') as $file) {
                    if ($file->getSize() > 30720 * 1024) { // 30MB in bytes
                        return redirect()->back()->with('error', 'One or more files exceed the 30MB size limit.');
                    }
                }

                // Proceed with storing files if size is valid
                $validated['uploaded_files'] = collect($request->file('uploaded_files'))->map(function ($file) {
                    return $file->store('uploads', 'public');
                })->toArray();
            }
            $validated['status'] = $request->input('status', 'active');
            $validated['id'] = 'IT/ASSETS-' . mt_rand(100000000000, 999999999999); // Random 12-digit number

            // Create asset
            Asset::create($validated);

            // Redirect back with success message
            return redirect()->back()->with('success', 'Asset registered successfully!');
        } catch (\Exception $e) {
            // Catch any exception and log the error
            Log::error('Asset registration failed: ' . $e->getMessage());

            // Redirect back with error message
            return redirect()->back()->with('error', 'There was an error registering the asset. Please try again.');
        }
    }

    // for seeing registered Assets [ITHD-15]
    public function assetsLists(){
        $assets = Asset::all();
        return view('assetsmanagement.assetslist', compact('assets'));
    }

    // for filter the controller 
    public function searchAssets(Request $request) {
        $search = $request->input('search');

        $assets = Asset::query()
            ->when($search, function($query, $search) {
                return $query->where('asset_type', 'like', "%$search%")
                    ->orWhere('brand', 'like', "%$search%")
                    ->orWhere('product_name', 'like', "%$search%")
                    ->orWhere('person_in_charge', 'like', "%$search%")
                    ->orWhere('status', 'like', "%$search%");
            })
            ->get();
            // return view('assetsmanagement.assetslist', compact('assets', 'search'));
            return response()->json($assets);
    }
}
