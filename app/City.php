<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Country
 * @package App
 */

class City extends Model
{
    protected $fillable  = [];
    protected $fieldspec = [];

	public function province()
	{
		return $this->belongsTo('App/Province', 'provinc_code', 'code');
	}
}
