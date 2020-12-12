<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

use \App\maguttiCms\Translatable\GFTranslatableHelperTrait;;

class Faq extends Model
{
    use GFTranslatableHelperTrait;
    use Translatable;

    protected $with = ['translations'];

    protected $fillable = [
        'title',
        'description',
        'image',
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
        'description'
    ];

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

        $this->fieldspec['description'] = [
            'type'     => 'text',
            'required' => 1,
            'hidden'   => 0,
            'size'     => 600,
            'h'        => 300,
            'label'    => trans('admin.label.description'),
            'display'  => 1,
            'cssClass' => 'wyswyg',
        ];

        $this->fieldspec['image'] = [
            'type'     => 'string',
            'required' => 0,
            'hidden'   => 0,
            'label'    => trans('admin.label.image'),
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
