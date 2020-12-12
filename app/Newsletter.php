<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
	protected $fillable = ['locale', 'name',  'email', 'sort', 'pub'];
	protected $fieldspec = [];

	function getFieldSpec ()
    {
        return $this->fieldspec;
    }
}
