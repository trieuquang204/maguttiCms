<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

use \App\maguttiCms\Translatable\GFTranslatableHelperTrait;
use \App\maguttiCms\Domain\Product\ProductPresenter;
use App\maguttiCms\Builders\ProductBuilder;


class Product extends Model
{
    use GFTranslatableHelperTrait;
    use Translatable;
    use ProductPresenter;

	protected $with = ['translations'];

    protected $fillable  = ['category_id','code','price','title','subtitle','description','video','slug','sort','pub', 'permalink'];
    protected $fieldspec = [];

    /*
    |--------------------------------------------------------------------------
    |  Sluggable & Trnslateble
    |--------------------------------------------------------------------------
    */
    public $translatedAttributes = ['title','slug','subtitle','description',
                                    'seo_title','seo_description', 'seo_no_index','permalink'];
    public $sluggable            =  ['slug'=>['field'=>'title','updatable'=>false,'translatable'=>1]];

    /*
    |--------------------------------------------------------------------------
    |  RELATION
    |--------------------------------------------------------------------------
    */

    public function category() {
        return $this->belongsTo('App\Category','category_id','id');
    }

	public function getAllCategories() {
		return $this->hasMany('App\Category');
	}

    public function models() {
        return $this->hasMany('App\ProductModel');
    }

    public function media() {
        return $this->morphMany('App\Media', 'model');
    }

    /*
    |--------------------------------------------------------------------------
    |  Builder & Repo
    |--------------------------------------------------------------------------
    */
    function newEloquentBuilder($query)
    {
        return new ProductBuilder($query);
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
        $this->fieldspec['category_id'] = [
            'type'        => 'relation',
            'model'       => 'Category',
            'foreign_key' => 'id',
            'label_key'   => 'title',
            'label'       => trans('admin.label.category'),
            'hidden'      => 0,
            'required'    => 1,
            'display'     => 1,
        ];
		$this->fieldspec['code'] = [
            'type'     => 'string',
            'required' => 1,
            'hidden'   => 0,
            'label'    => trans('admin.label.code'),
            'display'  => 1,
        ];
		$this->fieldspec['price'] = [
            'type'     => 'integer',
            'required' => 1,
            'hidden'   => 0,
            'label'    => trans('admin.label.price'),
            'display'  => 1,
			'step'     => 0.01
        ];
        $this->fieldspec['title'] = [
            'type'     => 'string',
            'required' => 1,
            'hidden'   => 0,
            'label'    => trans('admin.label.title'),
            'display'  => 1,
        ];
        $this->fieldspec['slug'] = [
            'type'     => 'string',
            'required' => 0,
            'hidden'   => 0,
            'label'    => trans('admin.label.slug'),
            'display'  => 1,
        ];
        $this->fieldspec['permalink'] = [
            'type'     => 'string',
            'required' => 0,
            'hidden'   => 0,
            'label'    => trans('admin.label.permalink'),
            'display'  => 1,
        ];
        $this->fieldspec['subtitle'] = [
            'type'     => 'string',
            'required' => false,
            'hidden'   => 0,
            'label'    => trans('admin.label.subtitle'),
            'display'  => 1,
        ];
        $this->fieldspec['description'] = [
            'type'      => 'text',
            'size'      => 600,
            'h'         => 300,
            'required'  => false,
            'hidden'    => 0,
            'label'     => trans('admin.label.description'),
            'cssClass'  => 'wyswyg',
            'display'   => 1,
        ];
        $this->fieldspec['image'] = [
            'type'      => 'media',
            'required'  => false,
            'hidden'    => 0,
            'label'     => trans('admin.label.image'),
            'mediaType' => 'Img',
            'display'   => 1,
            'disk' => 'images',
            'folder' => 'products',
        ];
		$this->fieldspec['doc'] = [
			'type'      => 'media',
			'required'  => false,
			'hidden'    => 0,
			'label'     => trans('admin.label.doc'),
			'mediaType' => 'Doc',
			'display'   => 1
		];
        $this->fieldspec['video'] = [
            'type'      => 'string',
            'required'  => false,
            'hidden'    => 1,
            'label'     => trans('admin.label.video'),
            'lang'      => 0,
            'display'   => 1,
        ];
        $this->fieldspec['sort'] = [
            'type'     => 'integer',
            'required' => false,
            'label'    => trans('admin.label.sort'),
            'hidden'   => 0,
            'display'  => 1,
        ];
        $this->fieldspec['pub'] = [
            'type'     => 'boolean',
            'required' => false,
            'hidden'   => 0,
            'label'    => trans('admin.label.publish'),
            'display'  => 1
        ];
        $this->fieldspec['seo_title'] = [
            'type'     => 'string',
            'required' => 'n',
            'hidden'   => 0,
            'label'    => trans('admin.seo.title'),
            'display'  => 1,
        ];
        $this->fieldspec['seo_description'] = [
            'type'     => 'text',
            'size'     => 600,
            'h'        => 300,
            'hidden'   => 0,
            'label'    => trans('admin.seo.description'),
            'cssClass' => 'no',
            'display'  => 1,
        ];
        $this->fieldspec['seo_no_index'] = [
            'type'     => 'boolean',
            'required' => false,
            'hidden'   => 0,
            'label'    => trans('admin.seo.no-index'),
            'display'  => 1
        ];
        return $this->fieldspec;
    }

}
