<?php
namespace App\Http\Controllers\Custom;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Requests\Custom;
use App\Http\Controllers\Controller;
use App\Space\Custom\Affiliated;

class ManagersController extends Controller
{
    public function show(Request $request)
    {
        $roles = [
            'general' => ['consultant', 'helper', 'lead', 'manager'],
            'helper' => ['consultant', 'lead', 'manager'],
            'consultant' => ['manager', 'lead'],
            'lead' => ['manager'],
            'manager' => ['manager']
        ];

		$child = $request->input('child_type') ?? null;

        //Get the availabe roles 
        $availabe_roles = $roles[$child] ?? [];

        // Get the list of users which role is higher
        return Affiliated::whereIn('type', $availabe_roles)
                ->whereIn('status', 1)
                ->orderBy('name', 'asc')
                ->get();
    }
    
    public function getLeaders(Request $request)
    {
        $query_search = $request->input('query');

        // Only for leaders
        $roles = [
            'manager',
            'lead',
            'consultant',
            'helper'
        ];

        if (strlen($query_search) >= 4) {
            
             return Affiliated::where(function($query) use ($query_search) {
                $query->where( 'name', 'LIKE', '%'. strtolower($query_search) . '%' )
                ->orWhere('last_name', 'LIKE', '%'. strtolower($query_search) . '%' );
             })
             ->where('status', '=', 1)
             ->whereIn('type', $roles)
             ->select('name', 'last_name', 'id')
             ->orderBy('name', 'asc')->paginate(10);
        }

        return response()->json([
            'message' => __('affiliates.saved')
        ],200);
    }
}
