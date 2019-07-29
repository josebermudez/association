<?php
namespace App\Http\Controllers\Custom;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Requests\Custom;
use App\Http\Controllers\Controller;
use App\Space\Custom\Notification;
use App\Space\Custom\Affiliated;

class NotificationsController extends Controller
{
    public function show(Request $request)
    {
		$filter = $request->input('filter');
		$sort = json_decode($request->input('sort'));
		$order = $sort->order ?? 'desc';
		$fieldName = $sort->fieldName ?? 'created_at';

		return Notification::where('name', 'LIKE', '%'. strtolower($filter) . '%' )
                ->orWhere('message', 'LIKE', '%'. strtolower($filter) . '%' )
				->orderBy($fieldName, $order)
				->paginate(5);
    }
	
	/**
     * Save a Notification
     *
     * @param Requests\NotificationRequest $request
     * @return View
     */
    public function store(Custom\NotificationsRequest $request)
    {
        $notification = new Notification();
        $data = $request->only($notification->getFillable());
        $notification->fill($data)->save();

        return response()->json([
            'message' => __('notifications.saved'),
            'notification' => $notification
        ],200);
    }

    /**
     * Deletes a Notification
     *
     * @param Requests\NotificationRequest $request
     * @return View
     */
    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();
        return response()->json([
            'message' => __('notifications.deleted')
        ],200);
    }

    public function sendSample(Request $request)
    {
        $phone = $request->input('phone');
        $notification_id = $request->input('notification');
        return response()->json([
            'message' => __('notifications.sample_sent')
        ],200);   
    }

    public function sendSms(Request $request)
    {
        $affiliates = $request->all()['params']['affiliates'];

        $notification_id = $request->input('notification');

        $notfication = Notification::find($notification_id);

        foreach ($affiliates as $target_id) {
            if ($notification_id && $affiliated = Affiliated::find($target_id)) {
                if(!empty($affiliated->cell_phone)) {
                    Log::info('Enviando mensaje a:'.$affiliated->cell_phone);
                    Notification::route(
                        'nexmo',
                        $affiliated->cell_phone
                    )->notify(new \App\Notifications\Event($notfication));
                }
            }
        }

        return response()->json([
            'message' => __('notifications.sent')
        ],200);   
    }
}
