<?php
/**
 * Created by PhpStorm.
 * User: web01
 * Date: 07/08/18
 * Time: 16:22
 */

namespace App\maguttiCms\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

use App\maguttiCms\Searchable\SearchableTrait;


/**
 * Class AdminListExporter
 * @package App\maguttiCms\Exports
 */
class AdminListExporter extends ExportHelper implements FromCollection, WithHeadings
{
    use Exportable;
    use SearchableTrait;

    /**
     *  set default extension as xlsx
     * AdminListExporter constructor.
     * @param $model
     * @param string $ext
     */
    function __construct($model)
    {
        $this->config = config('maguttiCms.admin.list.section.' . $model);
        $this->modelClass = 'App\\' . $this->config['model'];
        $this->setFilename($this->config['model'] . '_' . date('Y-m-d'));
        $this->request = request();
    }


    public function collection()
    {
        return collect($this->getDataToExport());
    }

    public function headings(): array
    {
        return $this->getHeadersFromConfig();
    }

    /**
     * @return array
     */
    public function getDataToExport()
    {
        $items = $this->getData();
        // split the result in chunk of 10000 items
        $items->each(function ($item) {
            $this->itemsArray[] = $this->mapData($item);
        }, 10000);
        return $this->itemsArray;
    }


    public function addHeader()
    {
        $this->itemsArray[] = $this->headings();
        return $this;
    }

    /**
     * @param $item
     * @return mixed
     */
    protected function mapData($item)
    {
        $dataArray = array();
        foreach ($this->config['field_exportable'] as $field) {

            $a = $field['field'];

            if ($field['type'] == 'text') {
                array_push($dataArray, $item->$a);
            }
            if ($field['type'] == 'relation') {

                if (isset($item->{$field['relation']}->{$field['field']})) {
                    array_push($dataArray, $item->{$field['relation']}->{$field['field']});
                } else {
                    array_push($dataArray, '');
                }
            }
            if ($field['type'] == 'integer') {
                array_push($dataArray, $item->$a);
            }
            if ($field['type'] == 'datetime') {
                array_push($dataArray, $item->$a->format('m-d-Y h:m'));
            }
        }
        return $dataArray;
    }

    /**
     *  Return the  query
     * @return mixed
     */
    protected function getData()
    {
        $this->model = new  $this->modelClass;
        $objBuilder = $this->model::query();
        $this->addSelect($objBuilder);
        $this->selectSub($objBuilder);
        $this->joinable($objBuilder);
        $this->whereFilter($objBuilder);
        $this->searchFilter($objBuilder);
        $this->orderFilter($objBuilder);
        $this->withRelation($objBuilder);
        $this->withHelperFilter($objBuilder);
        return $objBuilder;
    }


    public function withHelperFilter($objBuilder)
    {
        return (data_get($this->config, 'with_exportable')) ? $objBuilder->with($this->config['with_exportable']) : '';
    }
}