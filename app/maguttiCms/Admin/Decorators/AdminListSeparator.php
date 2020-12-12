<?php


namespace App\maguttiCms\Admin\Decorators;

/**
 * Trait AdminListSeparator
 * @package App\maguttiCms\Admin\Decorators
 */
trait AdminListSeparator
{
    protected $separator_attribute = null;
    protected $separator_attribute_value = null;
    protected $separator_col_span = 1;

    public function getGroupBySeparatorAttribute($article)
    {

        return ($this->separator_attribute != '') ? " data-group-by-separator=" . $this->getGroupBySeparatorValue($article) . " " : '';
    }

    public function getGroupBySeparatorValue($article)
    {
        return $this->separator_attribute_value =($this->separator_attribute != '') ? $article->{$this->separator_attribute} : '';
    }

    public function showGroupBySeparator($article)
    {
        if($this->separator_attribute=='') return;
        if(request()->has('orderBy')) return;
        return ($article->{$this->separator_attribute} != $this->separator_attribute_value)?true:false;
        }


    public function groupBySeparator()
    {
        $this->separator_attribute = data_get($this->property, 'group_by_separator_field', '');
    }

    protected function isGroupBySeparator($item)
    {
        return (data_get($item, 'type') == self::GROUP_BY_SEPARATOR) ? true : false;
    }

    protected function counterSpan()
    {
        $this->separator_col_span = (collect($this->property['field'])->count())+2;
    }
    public function separatorColSpan()
    {
        return $this->separator_col_span;
    }
}