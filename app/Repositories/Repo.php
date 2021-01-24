<?php

namespace App\Repositories;

use App\Exceptions\NotFoundException;
use App\Services\Pagination;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

abstract class Repo {

    /**
     * @param int $offset
     * @param int $limit
     * @return Pagination
     * @throws NotFoundException
     */
    abstract protected function all($offset = 0, $limit = 20): Pagination;

    /**
     * @param LengthAwarePaginator $lPagination
     * @param Collection $mapList
     * @param int $offset
     * @param int $limit
     * @return Pagination
     */
    protected function newPagination(
        LengthAwarePaginator $lPagination , Collection $mapList,  int $offset = 0, int $limit = 20
    ): Pagination {
        $pagination = new Pagination();
        $pagination->setItems($mapList);
        $pagination->setTotal($lPagination->total());
        $pagination->setPageId($offset);
        $pagination->setPerPage($limit);
        $pagination->setFirstItem($lPagination->firstItem());
        $pagination->setLastItem($lPagination->lastItem());
        $pagination->setLastPage($lPagination->lastPage());
        return $pagination;
    }
}
