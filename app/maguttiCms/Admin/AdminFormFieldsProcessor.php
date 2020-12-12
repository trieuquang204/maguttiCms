<?php namespace App\maguttiCms\Admin;



use App\maguttiCms\Admin\Helpers\AdminRelationsSaverTrait;
use App\maguttiCms\Admin\Helpers\AdminUserTrackerTrait;
use App\maguttiCms\Searchable\SearchableTrait;
use App\maguttiCms\Sluggable\SluggableTrait;
use App\maguttiCms\Tools\UploadManager;

/**
 * Class AdminFormFieldsProcessor
 * @package App\maguttiCms\Admin
 */
class AdminFormFieldsProcessor
{

    use AdminUserTrackerTrait;
    use AdminRelationsSaverTrait;
    use SluggableTrait;
    use SearchableTrait;

    protected $model;
    protected $request;
    protected $fieldSpecs;

    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * @param $model
     */
    public function requestFieldHandler($model)
    {
        $field = '';
        $this->fieldSpecs = collect($model->getFieldspec());
        //dd($this->request->all());
        foreach ($model->getFillable() as $field) {
            if ($this->request->has($field)) {
                $model->$field = $this->request->get($field);
            }
        }

        if (isset($model->sluggable)) {
            foreach ($model->sluggable as $key => $field) {
                if (!$this->slugIsTranslatable($field)) {
                    $slug_value = $this->request->get($key);
                    $source_value = $this->request->get($field['field']);
                    $model->$key = $this->setSlugAttributes($field)
                        ->sluggy($model, $slug_value, $source_value);
                }
            }
        }

        /** tiene traccia dell'utente che ha fatto le modifiche */
        $this->hackedBy($model);

        $this->processMedia($model);

        $model->save();

        $this->relationsSaver($model);

        $this->translationHandlers($model, $field);
    }


    /**
     * SAVE TRANSLATIONS
     * @param $model
     */
    function translationHandlers($model, $field)
    {

        // translatable
        if (isset($model->translatedAttributes) && count($model->translatedAttributes) > 0) {
            foreach (config('app.locales') as $locale => $value) {
                foreach ($model->translatedAttributes as $attribute) {
                    // se è un attributo sluggable;
                    if (isset($model->sluggable) && $this->attributeIsSluggable($attribute, $model->sluggable)) {
                        $attribute_to_slug = (config('app.locale') != $locale) ? $attribute . '_' . $locale : $attribute;
                        $string_value = $this->setSlugAttributes($field)
                            ->sluggyTranslatable($model, $this->request->get($attribute_to_slug), $locale);

                        $model->translateOrNew($locale)->$attribute = $string_value;
                    } elseif ($model->getFieldSpec()[$attribute]['type'] != 'media') {
                        if (config('app.locale') != $locale) {
                            $model->translateOrNew($locale)->$attribute = $this->request->get($attribute . '_' . $locale);
                        } else {
                            $model->translateOrNew($locale)->$attribute = $this->request->get($attribute);
                        }
                    }
                }
                $model->save();
            }
        }
    }


    /**
     * @param $model
     */
    private function processMedia($model)
    {
        foreach ($this->fieldSpecs->where('type', 'media')->all() as $key => $field) {
            $disk = data_get($field,'disk','');
            $folder = data_get($field,'folder','');

            if ($this->isTranslatableField($key)) {
                foreach (config('app.locales') as $locale => $value) {
                    $this->mediaHandlerLocale($model, $key, $disk, $folder, $locale);
                    $model->save();
                }
            } else {
                (isset($field['cropper'])) ? $this->cropperHandler($model, $key, $disk,
                    $folder) : $this->mediaHandler($model, $key, $disk, $folder);
            }
        }
    }


    /**
     * Perform the media upload
     * @param $model
     * @param $media
     */
    private function mediaHandler($model, $media, $disk = '', $folder = '')
    {
        $UM = new UploadManager;

        $model->$media = ($UM->init($media, $this->request,$disk,$folder)->store()->getFileFullName()) ?: $model->$media;
    }

    private function mediaHandlerLocale($model, $media, $disk = '', $folder = '', $locale)
    {
        $UM = new UploadManager;
        $media_locale = (config('app.locale') != $locale) ? $media . '_' . $locale : $media;
        $model->translateOrNew($locale)->$media = ($UM->init($media_locale, $this->request, $disk,
            $folder)->store()->getFileFullName()) ?: $model->translateOrNew($locale)->$media;

    }

    private function cropperHandler($model, $media, $disk = '', $folder = '')
    {
        $data = $this->request->$media;

        if (!$data) {
            return false;
        }

        $config = $model->getFieldSpec();
        $config = $config[$media];
        $config = collect($config['cropper']);

        $disk = $disk ?: 'media';
        $folder = $folder ?: 'images';

        $UM = new UploadManager;
        $file_details = ($UM->init($media, $this->request, $disk, $folder)->storeData($data,
            $this->request->{$media . '-filename'}, $config));

        $model->$media = $file_details['fullName'] ?: $model->$media;
    }
}
