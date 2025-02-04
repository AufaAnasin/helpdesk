<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\AssetLog;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

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
            $validated['id'] = 'ITASSETS' . mt_rand(100000000000, 999999999999); // Random 12-digit number

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
    public function assetsLists()
    {
        $assets = Asset::all();
        return view('assetsmanagement.assetslist', compact('assets'));
    }

    // for filter the controller 
    public function searchAssets(Request $request)
    {
        $search = $request->input('search');

        $assets = Asset::query()
            ->when($search, function ($query, $search) {
                return $query->where('asset_type', 'like', "%$search%")
                    ->orWhere('brand', 'like', "%$search%")
                    ->orWhere('product_name', 'like', "%$search%")
                    ->orWhere('person_in_charge', 'like', "%$search%")
                    ->orWhere('id', 'like', "%$search%")
                    ->orWhere('status', 'like', "%$search%");
            })
            ->get();
        // return view('assetsmanagement.assetslist', compact('assets', 'search'));
        return response()->json($assets);
    }


    // get asset detail by id
    public function getDetailById(Request $request)
    {
        $asset = Asset::where('id', $request->id)->first(); // Find the asset by ID

        if (!$asset) {
            abort(404, 'Asset not found'); // Show 404 if asset not found
        }

        return view('assetsmanagement.assetsdetail', compact('asset'));
    }
    public function editAssets(Request $request)
    {
        try {
            // Fetch the asset
            $asset = Asset::where('id', $request->query('id'))->first();

            if (!$asset) {
                return redirect()->back()->with('error', 'Asset not found.');
            }

            // Fetch asset logs
            $logs = AssetLog::where('asset_id', $asset->id)
                ->orderBy('created_at', 'desc')
                ->get();

            return view('assetsmanagement.assetsedit', compact('asset', 'logs'));
        } catch (\Exception $e) {
            Log::error('Error fetching asset: ' . $e->getMessage());

            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }

    // Update asset details and log changes
    public function updateAssets(Request $request)
    {
        try {
            $asset = Asset::where('id', $request->query('id'))->first();

            if (!$asset) {
                return redirect()->back()->with('error', 'Asset not found.');
            }

            // ✅ Validate inputs (make all fields optional)
            $validatedData = $request->validate([
                'status' => 'nullable|string|max:255',
                'person_in_charge' => 'nullable|string|max:255',
                'hardware_location' => 'nullable|string|max:255',
                'notes' => 'nullable|string',
                'is_borrowable_hidden' => 'required|integer|in:0,1',
            ]);

            // ✅ Ensure 'is_borrowable' is always updated
            $validatedData['is_borrowable'] = $validatedData['is_borrowable_hidden'];
            unset($validatedData['is_borrowable_hidden']);

            // ✅ Retain old values if fields are left empty
            $validatedData = array_filter($validatedData, function ($value) {
                return $value !== null && $value !== ''; // Remove empty fields
            });

            // ✅ Ensure 'person_in_charge' keeps the old value if not filled
            if (!isset($validatedData['person_in_charge'])) {
                $validatedData['person_in_charge'] = $asset->person_in_charge;
            }

            // ✅ Log changes
            foreach ($validatedData as $field => $newValue) {
                $oldValue = $asset->$field;

                if ($oldValue != $newValue) {
                    AssetLog::create([
                        'asset_id' => $asset->id,
                        'person_in_charge' => $asset->person_in_charge ?? 'N/A',
                        'status' => "Updated {$field} from '{$oldValue}' to '{$newValue}'",
                        'notes' => "Field updated: $field",
                        'edited_by' => Auth::id(),
                    ]);
                }
            }

            // ✅ Update only provided fields
            $asset->update($validatedData);

            return redirect()->route('assetsmanagement.assetsedit', ['id' => $asset->id])->with('success', 'Asset updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating asset: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An unexpected error occurred while updating the asset. Please try again later.');
        }
    }

    public function requestAssets(){
        $pageSlug = 'request-assets';
        return view('assetsmanagement.assetrequest', compact('pageSlug'));
    }
}
