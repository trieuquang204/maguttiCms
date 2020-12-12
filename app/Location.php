<?php namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

use App\maguttiCms\Builders\LocationBuilder;
use App\maguttiCms\Domain\Location\LocationPresenter;
use App\maguttiCms\Domain\Location\MapLocationPresenter;
use \App\maguttiCms\Translatable\GFTranslatableHelperTrait;

class Location extends Model
{
    use GFTranslatableHelperTrait;
    use LocationPresenter;
    use MapLocationPresenter;
    use Translatable;

    protected $with = ['translations'];

    protected $fillable = [
        'parent_id',
        'title',
        'subtitle',
        'description',
        'info',
        'full_address',
        'street',
        'number',
        'zip_code',
        'city',
        'province',
        'country_code',
        'phone',
        'mobile',
        'email',
        'vat',
        'slug',
        'doc',
        'link',
        'lat',
        'lng',
        'sort',
        'pub'
    ];

    protected $fieldspec = [];

    /*
    |--------------------------------------------------------------------------
    |  Sluggable & Translatable
    |--------------------------------------------------------------------------
    */
    public $translatedAttributes = [
        'title',
        'subtitle', 'slug',
        'description', 'info',
        'seo_title', 'seo_description', 'seo_no_index'
    ];

    public $sluggable = [
        'slug' => ['field' => 'title', 'updatable' => true, 'translatable' => 1]
    ];

    /*
    |--------------------------------------------------------------------------
    |  Builder & Repo
    |--------------------------------------------------------------------------
    */
    function newEloquentBuilder($query)
    {
        return new LocationBuilder($query);
    }

    /*
    |--------------------------------------------------------------------------
    |  RELATION
    |--------------------------------------------------------------------------
    */
    public function parents()
    {
        return $this->belongsTo('App\Location');
    }


    public function children()
    {
        return $this->hasMany('App\Location', 'parent_id', 'id');
    }

    public function countries()
    {
        return $this->belongsTo('App\Country');
    }

    public function media()
    {
        return $this->morphMany('App\Media', 'model');
    }

    public function gallery()
    {
        return $this->media()->where('collection_name', 'images');
    }

    /*
    |--------------------------------------------------------------------------
    |  Fieldspec
    |--------------------------------------------------------------------------
    */
    function getFieldSpec()
    {
        $this->fieldspec['id'] = [
            'type' => 'integer',
            'minvalue' => 0,
            'pkey' => 1,
            'required' => 1,
            'label' => trans('admin.label.id'),
            'hidden' => 1,
            'display' => 0,
        ];


        $this->fieldspec['parent_id'] = [
            'type' => 'relation',
            'model' => 'Location',
            'foreign_key' => 'id',
            'label_key' => 'title',
            'order_field' => 'sort',
            'required' => 0,
            'hidden' => 1,
            'display' => 1,
            'label' => trans('admin.label.parent'),
            'cssClass' => 'selectize',
        ];

        $this->fieldspec['title'] = [
            'type' => 'string',
            'required' => 1,
            'hidden' => 0,
            'label' => trans('admin.label.title'),
            'display' => 1,
        ];
        $this->fieldspec['subtitle'] = [
            'type' => 'string',
            'required' => 0,
            'hidden' => 0,
            'label' => trans('admin.label.subtitle'),
            'display' => 1,
        ];

        $this->fieldspec['slug'] = [
            'type' => 'string',
            'required' => false,
            'hidden' => 0,
            'label' => trans('admin.label.slug'),
            'display' => 1,
        ];

        $this->fieldspec['description'] = [
            'type' => 'text',
            'required' => 1,
            'hidden' => 0,
            'size' => 600,
            'h' => 300,
            'label' => trans('admin.label.description'),
            'display' => 1,
            'cssClass' => 'wyswyg',
        ];

        $this->fieldspec['info'] = [
            'type' => 'text',
            'required' => 0,
            'hidden' => 0,
            'size' => 600,
            'h' => 300,
            'label' => trans('admin.label.info'),
            'display' => 0,
            'cssClass' => 'wyswyg',
        ];
        $this->fieldspec['image'] = [
            'type' => 'media',
            'required' => 0,
            'hidden' => 0,
            'label' => trans('admin.label.image'),
            'mediaType' => 'Img',
            'display' => 1,
            'disk' => 'media',
        ];
        $this->fieldspec['doc'] = [
            'type' => 'media',
            'required' => 0,
            'hidden' => 0,
            'label' => trans('admin.label.doc'),
            'lang' => 0,
            'mediaType' => 'Doc',
            'display' => 1,
            'uploadifive' => 1,
            'accept' => '.pdf'
        ];

        $this->fieldspec['full_address'] = [
            'type' => 'string',
            'required' => 1,
            'hidden' => 0,
            'label' => trans('admin.label.address_full'),
            'display' => 1,
        ];


        $this->fieldspec['address'] = [
            'type' => 'component',
            'required' => 1,
            'hidden' => 0,
            'label' => trans('admin.label.address'),
            'extramsg' => '',
            'display' => 1,
            'validation' => [
                'street' => ['required'],
                'number' => ['required'],
                'zip_code' => ['required'],
            ],
        ];


        $this->fieldspec['country_code'] = [
            'type' => 'relation',
            'model' => 'Country',
            'foreign_key' => 'iso_code',
            'label_key' => 'name',
            'order_field' => 'name',
            'required' => 0,
            'hidden' => 0,
            'display' => 1,
            'label' => trans('admin.label.country'),
            'cssClass' => 'selectize',
        ];

        $this->fieldspec['phone'] = [
            'type' => 'string',
            'required' => 1,
            'hidden' => 0,
            'label' => trans('admin.label.phone'),
            'display' => 1,
        ];

        $this->fieldspec['mobile'] = [
            'type' => 'string',
            'required' => 1,
            'hidden' => 0,
            'label' => trans('admin.label.mobile'),
            'display' => 1,
        ];

        $this->fieldspec['email'] = [
            'type' => 'string',
            'required' => 1,
            'hidden' => 0,
            'label' => trans('admin.label.email'),
            'display' => 1,
        ];

        $this->fieldspec['vat'] = [
            'type' => 'string',
            'required' => false,
            'hidden' => 1,
            'label' => trans('admin.label.vat'),
            'display' => 1,
        ];
        $this->fieldspec['link'] = [
            'type' => 'string',
            'required' => false,
            'hidden' => 0,
            'label' => trans('admin.label.link'),
            'display' => 1,
        ];

        $this->fieldspec['geo_location'] = [
            'type' => 'component',
            'required' => 1,
            'hidden' => 0,
            'label' => trans('admin.label.lng'),
            'extramsg' => '',
            'display' => 1,
            'validation' => [
                'lng' => ['required'],
                'lat' => ['required'],
            ],
        ];

        $this->fieldspec['sort'] = [
            'type' => 'integer',
            'minvalue' => 0,
            'pkey' => 1,
            'required' => false,
            'label' => trans('admin.label.sort'),
            'hidden' => 0,
            'display' => 1,
        ];

        $this->fieldspec['pub'] = [
            'type' => 'boolean',
            'required' => 0,
            'hidden' => 0,
            'label' => trans('admin.label.pub'),
            'display' => 1,
        ];

        $this->fieldspec['seo_title'] = [
            'type' => 'seo_string',
            'required' => 0,
            'hidden' => 0,
            'label' => trans('admin.seo.title'),
            'display' => 1,
            'max' => 65
        ];
        $this->fieldspec['seo_description'] = [
            'type' => 'seo_text',
            'size' => 600,
            'h' => 300,
            'hidden' => 0,
            'label' => trans('admin.seo.description'),
            'cssClass' => 'no',
            'display' => 1,
        ];
        $this->fieldspec['seo_no_index'] = [
            'type' => 'boolean',
            'required' => 0,
            'hidden' => 0,
            'label' => trans('admin.seo.no-index'),
            'display' => 1
        ];

        return $this->fieldspec;
    }
}
