<?php namespace App;

use App\maguttiCms\Builders\MaguttiCmsBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Translatable;

use \App\maguttiCms\Translatable\GFTranslatableHelperTrait;;

class Metric extends Model

{
    use HasFactory;
    use GFTranslatableHelperTrait;
    use Translatable;

    protected $with = ['translations'];

    protected $fillable = [
        'title',
        'value',
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
        'title'
    ];

    /*
    |--------------------------------------------------------------------------
    |  Builder & Repo
    |--------------------------------------------------------------------------
    */
    function newEloquentBuilder($query)
    {
        return new MaguttiCmsBuilder($query);
    }


    public $sluggable = [
        'slug' => ['field' => 'title', 'updatable' => false, 'translatable' => 1]
    ];

    /*
    |--------------------------------------------------------------------------
    |  RELATION
    |--------------------------------------------------------------------------
    */
    

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
            'label'    => trans('admin.label.id'),
            'hidden'   => 1,
            'display'  => 0,
        ];

        $this->fieldspec['title'] = [
            'type'     => 'string',
            'required' => 1,
            'hidden'   => 0,
            'label'    => trans('admin.label.title'),
            'display'  => 1,
        ];

        $this->fieldspec['value'] = [
            'type'     => 'integer',
            'minvalue' => 0,
            'pkey'     => 1,
            'required' => 1,
            'label'    => trans('admin.label.value'),
            'hidden'   => 0,
            'display'  => 1,
        ];

        $this->fieldspec['sort'] = [
            'type'     => 'integer',
            'minvalue' => 0,
            'pkey'     => 1,
            'required' => 1,
            'label'    => trans('admin.label.sort'),
            'hidden'   => 0,
            'display'  => 1,
        ];

        $this->fieldspec['pub'] = [
            'type'     => 'boolean',
            'required' => 0,
            'hidden'   => 0,
            'label'    => trans('admin.label.pub'),
            'display'  => 1,
        ];

        return $this->fieldspec;
    }
}
