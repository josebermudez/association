<?php
namespace App\Http\Controllers\Custom;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Requests\Custom;
use App\Http\Controllers\Controller;
use App\Space\Custom\Affiliated;
use LaravelSmpp\SmppService;
use Illuminate\Support\Facades\Notification;

class AffiliatesController extends Controller
{
    public function show(Request $request)
    {
		$filter = $request->input('filter');
		$sort = json_decode($request->input('sort'));
		$order = $sort->order ?? 'desc';
		$fieldName = $sort->fieldName ?? 'created_at';

        // Search for a user based on their name.
        // Todo: Refactor this
        if ($request->has('search_by_notification')) {
            $affiliates = (new Affiliated)->newQuery();
            $types = $request->input('types');
            $leaders = $request->input('leaders');

            $filter_by_type = $this->getFilterByType($types ?? []);
            $filter_by_leader = $this->getFilterByType($leaders ?? []);

            if (count($filter_by_leader) > 0) {
                $affiliates->whereIn('manager_id', $filter_by_leader);
            }

            if ($filter_by_type) {
                $affiliates->whereIn('type', $filter_by_type);
            }

            return $affiliates->orderBy($fieldName, $order)->get();
        }

        if ($request->has('filter')) {
            return Affiliated::where('name', 'LIKE', '%'. strtolower($filter) . '%' )
                ->orWhere('last_name', 'LIKE', '%'. strtolower($filter) . '%' )
                ->orderBy($fieldName, $order)
                ->paginate(5);
        }
    }
	
	/**
     * Save a Affiliate
     *
     * @param Requests\AffiliateRequest $request
     * @return View
     */
    public function store(Custom\AffiliatesRequest $request)
    {
        $affiliated = new Affiliated();
        $data = $request->only($affiliated->getFillable());
        $data->status = 1;
        $affiliated->fill($data)->save();

        return response()->json([
            'message' => __('affiliates.saved'),
            'affiliate' => $affiliated
        ],200);
    }

    /**
     * Deletes a Affiliate
     *
     * @param Requests\AffiliateRequest $request
     * @return View
     */
    public function destroy($id)
    {
        $asffiliated = Affiliated::findOrFail($id);
        $affiliated->delete();
        return response()->json([
            'message' => __('affiliates.deleted')
        ],200);
    }

    protected function getFilterByType($filters = []) 
    {

        $type_filter = [];

        foreach($filters as $type) {
            $type = json_decode($type);
            $type_filter[] = $type->id;
        }

        return $type_filter;
    }
}
