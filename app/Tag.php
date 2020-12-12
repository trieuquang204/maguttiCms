<?php namespace App;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

use \App\maguttiCms\Translatable\GFTranslatableHelperTrait;

class Tag extends Model
{
    use Translatable;
    use GFTranslatableHelperTrait;


    protected $fillable  = ['title','slug'];
    protected $fieldspec = [];

    /*
    |--------------------------------------------------------------------------
    |  Sluggable & Trnslateble
    |--------------------------------------------------------------------------
    */

    public    $translatedAttributes = ['title'];
    public    $sluggable            = ['slug'=>['field'=>'title']];

    /*
    |--------------------------------------------------------------------------
    |  RELATION
    |--------------------------------------------------------------------------
    */

    public function news(){
        return $this->belongsToMany('App\News');
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
            'pkey'     => 'y',
            'required' => 1,
            'label'    => 'id',
            'hidden'   => 1,
            'display'  => 0,
        ];
        $this->fieldspec['title']   = [
            'type'      => 'string',
            'required'  => 1,
            'hidden'    => 0,
            'label'     => 'Title',
            'display'   => 1,
        ];
        $this->fieldspec['slug'] = [
            'type'      => 'string',
            'required'  => 0,
            'hidden'    => 0,
            'label'     => 'Slug',
            'display'   => 1,
        ];
        return $this->fieldspec;
    }

}
