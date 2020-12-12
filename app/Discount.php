<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Discount extends Model
{
	protected $with = [];

	protected $fillable = [
		'code',
		'amount',
		'description',
		'date_start',
		'date_end',
		'uses',
		'pub',
	];
	protected $fieldspec = [];



	public $sluggable = [];

	/*
	|--------------------------------------------------------------------------
	|  RELATION
	|--------------------------------------------------------------------------
	*/

	public function orders()
	{
		return $this->hasMany('App\Order', 'discount_code', 'code');
	}

	/*
	|--------------------------------------------------------------------------
	|  DATE ATTRIBUTE
	|--------------------------------------------------------------------------
	*/
	public function setDateStartAttribute($value)
	{
		if ($value) {
			$this->attributes['date_start'] = Carbon::parse($value);
		}
	}

	public function getDateStartAttribute($value)
	{
		if ($value) {
			return Carbon::parse($value)->format('d-m-Y');
		}
	}

	public function getFormattedDateStart()
	{
		return Carbon::parse($this->attributes['date_start'])->format('d-m-Y');
	}

	public function setDateEndAttribute($value)
	{
		if ($value) {
			$this->attributes['date_end'] = Carbon::parse($value);
		}
	}

	public function getDateEndAttribute($value)
	{
		if ($value) {
			return Carbon::parse($value)->format('d-m-Y');
		}
	}

	public function getFormattedDateEnd()
	{
		return Carbon::parse($this->attributes['date_end'])->format('d-m-Y');
	}

	/*
	|--------------------------------------------------------------------------
	|  Fieldspec
	|--------------------------------------------------------------------------
	*/
	function getFieldSpec()
	{
		$this->fieldspec['id'] = [
			'type'     => 'integer',
			'minvalue' => 0,
			'pkey'     => 1,
			'required' => 1,
			'label'    => 'id',
			'hidden'   => 1,
			'display'  => 0,
		];
		$this->fieldspec['code'] = [
			'type'     => 'string',
			'required' => 1,
			'hidden'   => 0,
			'label'    => trans('admin.label.code'),
			'display'  => 1,
		];
		$this->fieldspec['amount'] = [
            'type'     => 'integer',
            'required' => 1,
            'hidden'   => 0,
            'label'    => trans('admin.label.value'),
            'display'  => 1,
			'step'     => 0.01
        ];
		$this->fieldspec['description'] = [
			'type'     => 'string',
			'required' => 0,
			'hidden'   => 0,
			'label'    => trans('admin.label.description'),
			'display'  => 1,
		];
		$this->fieldspec['date_start'] = [
			'type'            => 'string',
			'required'        => 0,
			'hidden'          => 0,
			'label'           => trans('admin.label.date_start'),
			'display'         => 1,
			'cssClass'        => 'datepicker',
		];
		$this->fieldspec['date_end'] = [
			'type'            => 'string',
			'required'        => 0,
			'hidden'          => 0,
			'label'           => trans('admin.label.date_end'),
			'display'         => 1,
			'cssClass'        => 'datepicker',
		];
		$this->fieldspec['uses'] = [
			'type'     => 'integer',
			'required' => 0,
			'label'    => 'Usi',
			'hidden'   => 0,
			'display'  => 1,
		];
		$this->fieldspec['pub'] = [
			'type'     => 'boolean',
			'required' => 0,
			'hidden'   => 0,
			'label'    => trans('admin.label.pub'),
			'display'  => 1
		];

		return $this->fieldspec;
	}

	public function available()
	{
		if ($this->uses) {
			$used = $this->orders()->count();
			return ($this->uses - $used) > 0;
		} else {
			return true;
		}
	}

	public function inPeriod($value='')
	{
		$now = Carbon::now();
		if ($this->date_start) {
			$start = Carbon::parse($this->date_start);
			if ($now->lt($start)) {
				return false;
			}
		}
		if ($this->date_end) {
			$end = Carbon::parse($this->date_end)->addDay();
			if ($now->gt($end)) {
				return false;
			}
		}
		return true;
	}

	public function getAvailableDisplayAttribute()
	{
		if ($this->uses) {
			$used = $this->orders()->count();
			return $this->uses - $used;
		} else {
			return icon('infinity');
		}
	}
}
