<?php
namespace App\Space\Custom;

use Illuminate\Database\Eloquent\Model;
use  Illuminate\Support\Str;

class Affiliated extends Model
{
	 protected $table = 'affiliates';

	 protected $fillable = [
	 	'name',
	 	'last_name',
	 	'email',
	 	'address',
	 	'phone',
	 	'cell_phone',
	 	'birthday',
	 	'occupation',
	 	'marital_status',
	 	'number_of_children',
	 	'accepted_terms_conditions',
	 	'accept_contact_by_cell_phone',
	 	'accept_contact_by_phone',
	 	'accept_contact_by_email',
	 	'notes'
	 ];

}
