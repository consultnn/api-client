<?php

namespace consultnn\api;

class Company extends AbstractDomain
{

    /**
     * @param string $what
     * @param string $where
     * @param array $filters
     * @param int $page
     * @param int $perPage
     * @return \consultnn\api\mappers\Company[]
     *
     */
    public function search($what = null, $where = null, $filters = [], $page=1, $perPage = 100)
    {
        return $this->getInternalList(
            'company/search',
            'Company',
            [
                'what' => $what,
                'where' => $where,
                'filters' => $filters,
                'page' => $page,
                'per-page' => $perPage
            ]
        );
    }

    /**
     * @param $id
     * @return mappers\MapperInterface|mixed
     */
    public function getById($id)
    {
        $result =  $this->getSingle(
            'company/'.$id,
            'Company'
        );
        return $result;
    }
}
