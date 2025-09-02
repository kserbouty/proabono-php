<?php

/**
 * Base class for all list objects
 *
 * @copyright Copyright (c) 2025 ProAbono
 * @license MIT
 */
class ListBase implements Iterator, Countable
{
    private $items = null;
    private $position = 0;

    /**
     * @var null $page Page number your are on.
     */
    public $page = null;

    /**
     * @var null $sizePage Maximum number of items per page.
     */
    public $sizePage = null;

    /**
     * @var null $count Number of items on the current page.
     */
    public $count = null;

    /**
     * @var null $totalItems Number of items in this collection.
     */
    public $totalItems = null;

    public function __construct() {}

    /**
     * Rewind the Iterator to the first element.
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * Return the key of the current element.
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * Go to the next position.
     */
    public function next()
    {
        $this->position++;
    }

    /**
     * Checks if current position is valid.
     *
     * @return boolean
     */
    public function valid()
    {
        if (!isset($this->items))
            return false;

        return $this->position < sizeof($this->items);
    }

    /**
     * Return the current element.
     */
    public function current()
    {
        if (!isset($this->items))
            return null;

        return $this->items[$this->position];
    }    //

    /**
     * Count elements of an object.
     *
     * @return integer Return size of the subscriptions list.
     */
    public function count()
    {
        if (!isset($this->items))
            return 0;

        return sizeof($this->items);
    }

    /**
     * Initialize the pagination.
     *
     * @param $pagination
     */
    protected function init($pagination)
    {
        $this->page = $pagination->Page;
        $this->sizePage = $pagination->SizePage;
        $this->count = $pagination->Count;
        $this->totalItems = $pagination->TotalItems;
    }

    /**
     * Adds an element to the list
     *
     * @param $item
     */
    protected function push($item)
    {
        if (!isset($this->items))
            $this->items = array();

        array_push($this->items, $item);
    }
}
