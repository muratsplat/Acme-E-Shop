<?php

namespace App\Services;

use Illuminate\Support\Collection;

/**
 * This is simple pagination.
 *
 * Class Pagination
 * @package App\Services
 */
class Pagination {

    private Collection $items;
    private int $total;
    private int $perPage;
    private int $pageId;
    private int $lastPage;
    private int $firstItem;
    private int $lastItem;


    /**
     * @param Collection $items
     */
    public function setItems(Collection $items): void
    {
        $this->items = $items;
    }

    /**
     * @return Collection
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    /**
     * @param int $pageId
     */
    public function setPageId(int $pageId): void
    {
        $this->pageId = $pageId;
    }

    /**
     * @return int
     */
    public function getPageId(): int
    {
        return $this->pageId;
    }

    /**
     * @param int $perPage
     */
    public function setPerPage(int $perPage): void
    {
        $this->perPage = $perPage;
    }

    /**
     * @return int
     */
    public function getPerPage(): int
    {
        return $this->perPage;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @param int $total
     */
    public function setTotal(int $total): void
    {
        $this->total = $total;
    }

    /**
     * @param int $lastPage
     */
    public function setLastPage(int $lastPage): void
    {
        $this->lastPage = $lastPage;
    }

    /**
     * @return int
     */
    public function getLastPage(): int
    {
        return $this->lastPage;
    }

    /**
     * @return int
     */
    public function getFirstItem(): int
    {
        return $this->firstItem;
    }

    /**
     * @param int $firstItem
     */
    public function setFirstItem(int $firstItem): void
    {
        $this->firstItem = $firstItem;
    }

    /**
     * @return int
     */
    public function getLastItem(): int
    {
        return $this->lastItem;
    }

    /**
     * @param int $lastItem
     */
    public function setLastItem(int $lastItem): void
    {
        $this->lastItem = $lastItem;
    }
}
