<?php

namespace App\maguttiCms\TreeAble;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TreeGenerator
 * @package App\maguttiCms\TreeAble
 */
class TreeGenerator extends Model
{
    //
    protected $tree = [];
    protected $collection;
    protected $parent_field = 'parent_id';

    public function __construct($collection)
    {
        $this->collection = $collection;
    }

    /**
     * @return mixed
     */
    public function getTree()
    {
        return $this->tree;
    }

    /**
     * @param $item
     */
    public function addItemToTree($item): void
    {
        $this->tree[] = $item;
    }

    function treeable($parent_id = null, $level = 0)
    {
        if ($this->collection) {
            $level++;
            foreach ($this->collection->where($this->parent_field, $parent_id) as $tree_item) {
                $tree_item->level = $level;
                $this->addItemToTree($tree_item);
                $this->treeable($tree_item->id, $level);
            }
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * @param mixed $parent_field
     * @return TreeDecorator
     */
    public function setParentField($parent_field)
    {
        $this->parent_field = $parent_field;
        return $this;
    }
}
