<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
{
    //
    public function autocomplete(Request $request)
    {
        $search = $request->get('query'); // Get input query

        $employees = Employee::where('full_name', 'LIKE', "%{$search}%")
            ->limit(10)
            ->get(['sid', 'full_name', 'jobtitle', 'division', 'email']);

        return response()->json($employees);
    }
}
