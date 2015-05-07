<?php

namespace consultnn\api;

class Company extends AbstractDomain
{

    /**
     * @param array $filters
     * @param int $page
     * @param int $pageSize
     * @return \consultnn\api\mappers\Company[]
     */
    public function search($filters = [], $page=1, $pageSize=100)
    {
        return $this->getInternalList(
            'company/search',
            'Company',
            array_merge(
                $filters,
                [
                    'page' => $page,
                    'per-page' => $pageSize
                ]
            )
        );
    }

    public function getById($id)
    {
        $result =  $this->getInternalList(
            'company/id',
            'Company',
            [
                'id' => $id,
            ]
        );
        return current($result);
    }
}
