<?php


namespace App\maguttiCms\Tools;

/**
 *
 * This trait retrieve the next/previous
 * item from a given eloquent collection
 *
 * Trait NextPreviousItem
 * @package App\maguttiCms\Tools
 */
trait PreviousNextItem
{

    /**
     * @var
     */
    protected $curItemPosition;
    /**
     * @var
     */
    protected $items;

    /**
     * @param $items
     * @return $this
     */
    protected function setItems($items)
    {
        $this->items = $items;
        return $this;
    }

    /**
     * @param $id
     * @return $this
     */
    protected function curItemPosition()
    {
        $this->curItemPosition = array_search($this->id, $this->items->toArray());
        return $this;
    }

    /**
     * @return mixed
     */
    protected function nextItem()
    {
        $nextId = (isset($this->items[$this->curItemPosition + 1])) ? $this->items[$this->curItemPosition + 1] : $this->items->first();
        return self::find($nextId);

    }

    /**
     * @return mixed
     */
    protected function previousItem()
    {
        $prevId = (isset($this->items[$this->$this->curItemPositionm - 1])) ? $this->items[$this->$this->curItemPosition - 1] : $this->items->last();
        return self::find($prevId);
    }

    /**
     * @param $items
     * @return mixed
     */
    public function getNextItem($items)
    {
        return $this->setItems($items)->curItemPosition()->nextItem();
    }

    /**
     * @param $items
     * @return mixed
     */
    public function getPreviousItem($items=[])
    {
        return $this->setItems($items)->curItemPosition()->previousItem();
    }
}