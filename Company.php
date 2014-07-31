<?php

namespace consultnn\api;

class Company extends AbstractDomain
{

    public function byRubricIds(array $ids)
    {
        return $this->getInternalList(
          'company/search',
           'Company',
            [
                'params' => [
                    'rubrics' => $ids
                ]
            ]
        );
    }

}
