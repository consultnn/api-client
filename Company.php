<?php

namespace consultnn\api;

class Company extends AbstractDomain
{

    /**
     * @param array $ids
     * @param array $filters
     * @param int $page
     * @param int $pageSize
     * @return \consultnn\api\mappers\Company[]
     */
    public function byRubricIds(array $ids, array $filters = [],  $page=1, $pageSize=100)
    {
        return $this->getInternalList(
            'company/search',
            'Company',
            [
                'rubrics' => implode(',', $ids),
                'page' => $page,
                'pageSize' => $pageSize,
                'params' => $filters
            ]
        );
    }

    public function getBranches($id, $page=1, $pageSize=100)
    {
        return $this->getInternalList(
            'company/search',
            'Company',
            [
                'page' => $page,
                'pageSize' => $pageSize,
                'params' => [
                    'head_office_id' => $id,
                    'is_head_office' => false
                ]
            ]
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
