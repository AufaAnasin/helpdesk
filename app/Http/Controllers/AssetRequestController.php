<?php

namespace App\Http\Controllers;

use App\Models\AssetRequest;
use Illuminate\Http\Request;

class AssetRequestController extends Controller
{
    //
    public function requestAssets()
    {
        return view('assetrequest.assetrequest');
    }
    public function reviewAssetsRequest()
    {
        return view('assetrequest.review');
    }
    public function submit(Request $request)
    {
        $requests = json_decode($request->input('requests'), true);

        foreach ($requests as $req) {
            AssetRequest::create([
                'asset_type' => $req['asset_type'], // ✅ Ensure asset type is stored
                'brand' => $req['brand'],
                'product_name' => $req['product_name'],
                'amount' => $req['amount'],
                'notes' => $req['notes']
            ]);
        }

        return redirect('/request-assets')->with('success', 'Request submitted successfully!');
    }
}
