<?php namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


use \App\maguttiCms\Translatable\GFTranslatableHelperTrait;
use \App\maguttiCms\Domain\News\NewsPresenter;
use App\maguttiCms\Builders\NewsBuilder;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class News extends Model
{

    use GFTranslatableHelperTrait;
    use Translatable;
    use NewsPresenter;

	protected $with = ['translations'];

	protected  $fillable        = ['title','subtitle','description','date','date_start','sort','pub'];
	protected  $fieldspec       = [];

	/*
    |--------------------------------------------------------------------------
    |  Sluggable & Translateble
    |--------------------------------------------------------------------------
    */
    public $translatedAttributes    = ['title','subtitle','slug','description','seo_title','seo_description'];
    public $sluggable               = ['slug'=>['field'=>'title','updatable'=>false]];

    /*
    |--------------------------------------------------------------------------
    |  RELATIONS
    |--------------------------------------------------------------------------
    */
    public function media()
    {
        return $this->morphMany('App\Media', 'model')->orderBy('sort');
    }

    public function tags(){
        return $this->belongsToMany('App\Tag');
    }

    public function saveTags($values)
    {
        if(!empty($values))
        {
            $values = array_filter($values);
            $this->tags()->sync($values);
        } else {
            $this->tags()->detach();
        }
    }

    /*
    |--------------------------------------------------------------------------
    |  Builder & Repo
    |--------------------------------------------------------------------------
    */
    function newEloquentBuilder($query)
    {
        return new NewsBuilder($query);
    }

    /*
    |--------------------------------------------------------------------------
    |  DATE ATTRIBUTE
    |--------------------------------------------------------------------------
    */
    public function setDateAttribute($value)
    {
        $this->attributes['date'] = Carbon::parse($value);

    }

    public function getDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
        //return Carbon::parse($value)->format('d-m-Y H:i:s');
    }

    public function setDateStartAttribute($value)
    {
        $this->attributes['date_start'] = Carbon::parse($value);
    }

    public function getDateStartAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    public function getFormattedDate()
    {
        //return Carbon::parse($this->attributes['date'])->formatLocalized('%d %B %Y');
        return Carbon::parse($this->attributes['date'])->format('d-m-Y');
    }



    /*
    |--------------------------------------------------------------------------
    |  Fieldspec
    |--------------------------------------------------------------------------
    */
	function getFieldSpec ()
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
		$this->fieldspec['date'] = [
			'type'            => 'string',
			'required'        => 1,
			'hidden'          => 0,
			'label'           => __('admin.label.date_publish'),
			'display'         => 1,
			//'cssClass'      => 'datetimepicker',
            'cssClass'        => 'datepicker',
			'cssClassElement' => 'col-sm-2',
            'row-item'        => 'start'
		];
        $this->fieldspec['date_start'] = [
            'type'            => 'date',
            'required'        => 1,
            'hidden'          => 0,
            'label'           => __('admin.label.date_start'),
            'display'         => 1,
            'cssClass'        => 'datepicker',
            'cssClassElement' => 'col-sm-2',
            'row-item'        => 'stop',
            'validation'      => 'required|date_format:d-m-Y',
        ];
		$this->fieldspec['title'] = [
			'type'      =>'string',
			'required'  => 1,
			'hidden'    => 0,
			'label'     => 'Title',
			'display'   => 1,
		];


        $this->fieldspec['subtitle'] = [
            'type' => 'string',
            'required' => 0,
            'hidden' => 0,
            'label' => trans('admin.label.subtitle'),
            'display' => 1,

        ];
		$this->fieldspec['slug'] = [
			'type'      => 'string',
			'required'  => 1,
			'hidden'    => 0,
			'label'     => 'Slug',
			'display'   => 1,
		];
		$this->fieldspec['description'] = [
			'type'      => 'text',
			'size'      => 600,
			'h'         => 300,
			'required'  => 1,
			'hidden'    => 0,
			'label'     => 'Description',
			'cssClass'  => 'wyswyg',
			'display'   => 1,
		];
		$this->fieldspec['tag'] = [
            'type'       	=> 'relation',
            'model'      	=> 'Tag',
            'relation_name' => 'tags',
            'foreign_key'   => 'id',
			'label_key'     => 'title',
			'label'         => 'Tags',
            'required'      => 1,
			'display'       => 1,
            'hidden'        => 0,
			'multiple'      => 1
		];
		$this->fieldspec['link'] = [
			'type'      => 'string',
			'size'      => 600,
			'required'  => 1,
			'hidden'    => 0,
			'label'     => 'External url',
			'display'=>0,
		];
		$this->fieldspec['image'] = [
			'type'      =>'media',
			'required'  => 0,
			'hidden'    => 0,
			'label'     => 'Image',
			'extraMsgEnabled'=>'Code',
			'mediaType' => 'Img',
			'display'   => 1,
		];
		$this->fieldspec['doc'] = [
			'type'      =>'media',
			'required'  =>'n',
			'hidden'    => 0,
			'label'     =>'Document',
			'lang'      => 0,
			'mediaType' => 'Doc',
			'display'   => 0,
		];
        $this->fieldspec['sort'] = [
            'type'     => 'integer',
            'required' => 0,
            'label'    => 'Order',
            'hidden'   => 0,
            'display'  => 1,
        ];
        $this->fieldspec['pub'] = [
            'type'     => 'boolean',
            'required' => 0,
            'hidden'   => 0,
            'label'    => trans('admin.label.publish'),
            'display'  => 1
        ];
        $this->fieldspec['seo_title'] = [
            'type'     => 'seo_string',
            'required' => 0,
            'hidden'   => 0,
            'label'    => trans('admin.seo.title'),
            'display'  => 1,
            'max'      => 65
        ];
        $this->fieldspec['seo_description'] = [
            'type'     => 'seo_text',
            'size'     => 600,
            'h'        => 300,
            'hidden'   => 0,
            'label'    => trans('admin.seo.description'),
            'cssClass' => 'no',
            'display'  => 1,
        ];
        $this->fieldspec['seo_no_index'] = [
            'type'     => 'boolean',
            'required' => 0,
            'hidden'   => 0,
            'label'    => trans('admin.seo.no-index'),
            'display'  => 0
        ];
	    return $this->fieldspec;
	}



}
