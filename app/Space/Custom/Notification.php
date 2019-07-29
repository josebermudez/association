<?php
namespace App\Space\Custom;

use Illuminate\Database\Eloquent\Model;
use  Illuminate\Support\Str;

class Notification extends Model
{
	const CREATED = 1;
    const SENT = 2;

    const STATUSES = [
    	self::CREATED => 'notifications.created',
    	self::SENT => 'notifications.sent'
    ];

	 protected $fillable = [
	 	'name',
	 	'message',
	 	'from',
	 	'provider',
	 	'status',
	 	'notes'
	 ];

	protected $attributes = [
    	'provider' => 'Nexmo',
        'status' => self::CREATED
    ];


    public function getStatusAttribute($value)
	{
		return trans(self::STATUSES[$value]);
	}

}
