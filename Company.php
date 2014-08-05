<?php

namespace consultnn\api;

class Company extends AbstractDomain
{
    public function byRubricIds(array $ids, $page=1, $pageSize=100)
    {
        return $this->getInternalList(
            'company/search',
            'Company',
            [
                'rubrics' => implode(',', $ids),
                'page' => $page,
                'pageSize' => $pageSize
            ]
        );
    }
}
