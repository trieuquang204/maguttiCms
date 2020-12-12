<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

use Astrotomic\Translatable\Translatable;
use \App\maguttiCms\Translatable\GFTranslatableHelperTrait;

use App\maguttiCms\Domain\Block\BlockPresenter;


/**
 * Class Block
 * @package App
 */
class Block extends Model
{
    use Translatable;
    use GFTranslatableHelperTrait;
    use BlockPresenter;

    protected $fillable = [
        'model_id',
        'model_type',
        'template_id',
        'title',
        'subtitle',
        'description',
        'doc',
        'image',
        'video',
        'link',
        'sort',
        'pub',
        'translatables'
    ];
    protected $fieldspec = [];


    /*
    |--------------------------------------------------------------------------
    |  RELATIONS
    |--------------------------------------------------------------------------
    */


    public function model()
    {
        return $this->morphTo();
    }

    public function media()
    {
        return $this->morphMany('App\Media', 'model');
    }
    public function template()
    {
        return $this->belongsTo('App\Domain', 'template_id', 'id');
    }
    public function imageMedia()
    {
        return $this->belongsTo('App\Media', 'image', 'id');
    }


    /*
    |--------------------------------------------------------------------------
    |  Sluggable & Trnslateble
    |--------------------------------------------------------------------------
    */
    public $translatedAttributes = [
        'title',
        'description',
        'subtitle'
    ];

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
        $this->fieldspec['model_type'] = [
            'type'     => 'string',
            'required' => 1,
            'hidden'   => 1,
            'label'    => "Type",
            'display'  => 1,
            'default_value' => (request()->has('model'))?get_class(getModelFromString('article')):''
        ];
        $this->fieldspec['model_id'] = [
            'type'     => 'integer',
            'minvalue' => 0,
            'pkey'     => 1,
            'required' => 1,
            'label'    => 'model_id',
            'hidden'   => 1,//request()->has('model_id'),
            'display'  => 1,
            'default_value' => request()->get('model_id')
        ];
        $this->fieldspec['template_id'] = [
            'type'        => 'relation',
            'model'       => 'Domain',
            'filter'      => ['domain' => 'template'],
            'foreign_key' => 'id',
            'label_key'   => 'title',
            'required'    => 0,
            'label'       => trans('admin.label.template'),
            'hidden'      => 0,
            'display'     => 1,
        ];
        $this->fieldspec['title'] = [
            'type'     => 'string',
            'required' => 1,
            'hidden'   => 0,
            'label'    => trans('admin.label.title'),
            'display'  => 1,
        ];
        $this->fieldspec['subtitle'] = [
            'type'     => 'string',
            'required' => 0,
            'hidden'   => 0,
            'label'    => trans('admin.label.subtitle'),
            'display'  => 1,
        ];
        $this->fieldspec['description'] = [
            'type'     => 'text',
            'size'     => 600,
            'h'        => 300,
            'required' => 0,
            'hidden'   => 0,
            'label'    => trans('admin.label.description'),
            'cssClass' => 'wyswyg',
            'display'  => 1,
        ];
        $this->fieldspec['link'] = [
            'type'     => 'string',
            'required' => 0,
            'hidden'   => 0,
            'label'    => trans('admin.label.ext_url'),
            'display'  => 1,
        ];
        $this->fieldspec['image'] = [
            'type'      => 'media',
            'required'  => 0,
            'hidden'    => 0,
            'label'     => trans('admin.label.image'),
            'mediaType' => 'Img',
            'display'   => 1,
            'disk'      => 'media',
            'accept'	=> '.jpg'
        ];
        $this->fieldspec['doc'] = [
            'type'        => 'media',
            'required'    => 0,
            'hidden'      => 0,
            'label'       => trans('admin.label.doc'),
            'lang'        => 0,
            'mediaType'   => 'Doc',
            'display'     => 1,
            'uploadifive' => 1,
            'accept'	=> '.pdf'
        ];
        $this->fieldspec['video'] = [
            'type'     => 'string',
            'required' => 0,
            'hidden'   => 0,
            'label'    => "YouTube video code",
            'display'  => 1,
        ];
        $this->fieldspec['sort'] = [
            'type'     => 'integer',
            'required' => 0,
            'label'    => trans('admin.label.position'),
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




        return $this->fieldspec;
    }
}
