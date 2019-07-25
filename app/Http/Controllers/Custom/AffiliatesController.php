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
        /*print_r(Notification::route(
            'nexmo',
            '573113170663'
        )->notify(new \App\Notifications\Event()));
die;*/

		$filter = $request->input('filter');
		$sort = json_decode($request->input('sort'));
		$order = $sort->order ?? 'desc';
		$fieldName = $sort->fieldName ?? 'created_at';

		return Affiliated::where('name', 'LIKE', '%'. strtolower($filter) . '%' )
                ->orWhere('last_name', 'LIKE', '%'. strtolower($filter) . '%' )
				->orderBy($fieldName, $order)
				->paginate(5);
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
}
