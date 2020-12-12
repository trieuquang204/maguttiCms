<?php namespace App\maguttiCms\Admin\Controllers;

use App\maguttiCms\Tools\JsonApiResponseTrait;
use Illuminate\Http\Request;
use Input;
use Image;

class SuggestAjaxController extends AjaxController
{
    use JsonApiResponseTrait;

    /**
     * This method is used to perform a search for select 2 suggestion fields.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */

    public function suggest(Request $request)
    {
        // Validate the request.
        $request->validate([
            'q' => 'required',
            'model' => 'required',
            'value' => 'required',
            'caption' => 'required',
        ]);

        // Set convenience variables.
        $term = $request->q;
        $model = getModelFromString($request->model);
        $value = $request->value;
        $caption = $request->caption;
        $searchField = (isset($request->searchFields) && $request->searchFields != '') ? $request->searchFields : $caption;

        if (!$this->validateRequest($model, $caption)) return response()->json([]);

        // Check if the field is translatable.
        if ($this->isTranslatableField($model, $caption)) {
            $records = $model::select('*')->whereTranslationLike($caption, "%{$term}%");

        } else {
            // This is the simplest case where we know exactly what's the field to search.
            $records = $model::select('*');
            $searchFieldsList = explode(',', $searchField);
            foreach ($searchFieldsList as $_field) {
                $records->orWhere($_field, 'like', "%{$term}%");
            }
        }

        if ($request->has('where') && $request->where != '') {
            $records = $records->whereRaw($request->where);
        }

        $items = $records->get()->map(function ($record) use ($value, $caption) {
            return ['id' => $record->$value, 'value' => $record->$caption];
        });

        return response()->json($items);
    }

    /**
     * This method is used to validate if the
     * caption value it's not set in
     * model hidden Fields
     * @param $model
     * @param $caption
     * @return bool
     */
    function validateRequest($model, $caption)
    {
        return (collect($model->getHidden())->contains($caption)) ? false : true;
    }

}
