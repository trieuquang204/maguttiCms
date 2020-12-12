<?php namespace App\maguttiCms\Searchable;

use Str;
use Carbon\Carbon;
Use Form;
Use App;

/**
 * Trait SearchableTrait
 * @package App\maguttiCms\Searchable
 */
trait SearchableTrait
{

    protected $table;
    protected $translatableTable;
    public $queryBuilder;

    public static function bootSearchableTrait()
    {
        static::created(function ($item) {
            // Index the itemcompo
        });
    }


    public function mainTableSelect($objBuilder)
    {

        if (is_null($objBuilder->getQuery()->columns)) {
            $objBuilder->select($this->model->getTable() . '.*');
        }

        return;
    }

    public function addSelect($objBuilder)
    {
        return ($this->configHasProperty('addSelect')) ? $objBuilder->addSelect($this->config['addSelect']) : '';
    }

    public function selectSub($objBuilder)
    {
        return ($this->configHasProperty('selectSub')) ? $objBuilder->selectSub($this->config['selectSub']['query'], $this->config['selectSub']['field']) : '';
    }


    /**
     * GF_ma with relation
     * add with relation to
     * the query list
     * @param $objBuilder
     * @return mixed
     */
    public function withRelation($objBuilder)
    {
        return ($this->configHasProperty('withRelation')) ? $objBuilder->with($this->config['withRelation']) : '';
    }

    /**
     *  GF_ma search handler
     *
     * @param $objBuilder : The QueryBuilder.
     */
    public function searchFilter($objBuilder)
    {
        if (isset($this->config['field_searchable']) && $this->request->all() != '') {
            foreach ($this->config['field_searchable'] as $key => $value) {
                if ($this->request->filled($key)) {
                    $curValue = $this->request->$key;
                    if ($this->isTranslatableField($key)) {
                        $objBuilder->whereTranslationLike($key, "%" . $curValue . "%");
                    } else {
                        if ($value['type'] == 'relation') {
                            $objBuilder->whereHas($value['relation'], function ($query) use ($value, $curValue) {
                                $query->where((isset($value['key']) ? $value['key'] : 'id'), $curValue);
                            });
                        } elseif ($value['type'] == 'date') {
                            $objBuilder->whereDate($key, '=', Carbon::parse(str_replace('/', '-', $curValue)));
                        } elseif ($value['type'] == 'date_range') {
                            $field = $value['field'];
                            if ($this->request->filled('from_date') && $this->request->filled('to_date')) {
                                $date_from = Carbon::parse(str_replace('/', '-', $this->request->get('from_date')));
                                $date_to = Carbon::parse(str_replace('/', '-', $this->request->get('to_date')));
                                $objBuilder->whereBetween($field, [$date_from, $date_to]);
                            } else {
                                $objBuilder->whereDate($field, '=', Carbon::parse(str_replace('/', '-', $curValue)));
                            }
                        } elseif ($value['type'] == 'integer') {
                            $objBuilder->where($key, $curValue);
                        } elseif (isset($value['value']) && $this->whereStrictMode($value['value'])) {
                            $objBuilder->where($key, $curValue);
                        } elseif (data_get($value, 'mode') == 'strict') {
                            $objBuilder->where($key, '=', $curValue);
                        } else {
                            $objBuilder->where($key, 'like', "%" . $curValue . "%");
                        }
                    }
                }
            }
        }
    }

    public function whereFilter($objBuilder)
    {
        return ($this->configHasProperty('whereFilter')) ? $objBuilder->whereRaw($this->config['whereFilter']) : '';
    }


    public function orderFilter($objBuilder)
    {
        $this->setOrderBy();
        if ($this->isTranslatableField($this->sort)) {
            $objBuilder->TranslationOrderable($this->sort, $this->sortType, app()->getLocale());
        } else {
            return $objBuilder->orderByRaw($this->sort . ' ' . $this->sortType);
        }
    }


    public function setOrderBy()
    {
        $sort = (isset($this->config['orderBy'])) ? $this->config['orderBy'] : 'id';
        $sortType = (isset($this->config['orderType'])) ? $this->config['orderType'] : 'asc';
        $this->sort = ($this->request->has('orderBy')) ? $this->request->orderBy : $sort;
        $this->sortType = ($this->request->has('orderType')) ? $this->request->orderType : $sortType;

        return $this;
    }

    /*
     * SIMPLE JOIN TABLE IN THE LIST
     */
    public function joinable($objBuilder)
    {
        $joinTable = (isset($this->config['joinTable'])) ? trim($this->config['joinTable']) : "";
        $foreignJoinKey = (isset($this->config['foreignJoinKey'])) ? $this->config['foreignJoinKey'] : "id";
        $localJoinKey = (isset($this->config['localJoinKey'])) ? $this->config['localJoinKey'] : Str::singular($joinTable) . "_id";
        if ($joinTable != '') {
            $objBuilder->leftJoin($joinTable, $joinTable . '.' . $foreignJoinKey, '=',
                $this->model->getTable() . '.' . $localJoinKey);
            $this->mainTableSelect($objBuilder);
            if ($this->configHasProperty('joinFields')) {
                $objBuilder->addSelect($this->config['joinFields']);
            }
        }
    }

    /**
     *  GF_ma   check is  the  field is translatable
     * @param $key
     * @return bool
     */
    protected function isTranslatableField($key)
    {
        if (property_exists($this->model, 'translatedAttributes') && in_array($key,
                $this->model->translatedAttributes)) {
            return true;
        }
        return false;
    }

    /**
     * @return mixed
     */
    public function getMainTable()
    {
        return $this->model->getTable();
    }

    /**
     * @return mixed
     */
    public function getTranslatableTable()
    {
        return $this->model->getTranslationsTable();
    }

    /**
     * @param mixed $translatableTable
     */
    public function setTranslatableTable($translatableTable)
    {
        $this->translatableTable = $translatableTable;
    }

    /**
     * @param $model
     *
     * @return $this
     */
    public function setCurModel($model)
    {
        $this->model = $model;
        return $this;
    }

    private function whereStrictMode($key)
    {
        if ($key == 'id') {
            return true;
        }
    }

    function configHasProperty($property)
    {
        return data_get($this->config, $property);
    }
}
