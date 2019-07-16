<?php
namespace App\Space\Custom;

use Illuminate\Database\Eloquent\Model;
use  Illuminate\Support\Str;

class Product extends Model
{
	protected $appends = [
		'descriptionTruncate'
	];

    public function getDescriptionTruncateAttribute()
	{
		return Str::limit($this->description, 30);
	}
}
