<?php

namespace consultnn\api;

/**
 * Class Company
 * supported expand: phones, internet, schedule, sphere, type
 * @package consultnn\api
 */
class Company extends AbstractDomain
{
    /**
     * supported filters:
     *  rubrics - list of rubric IDs
     * @param string $what
     * @param string $where
     * @param array $filters
     * @param array $expand List of expand parameters
     * @param int $page
     * @param int $perPage
     * @return \consultnn\api\mappers\Company[]
     *
     */
    public function search($what = null, $where = null, $filters = [], $expand = [], $page=1, $perPage = 100)
    {
        return $this->getInternalList(
            'company/search',
            'Company',
            [
                'what' => $what,
                'where' => $where,
                'filters' => $filters,
                'expand' => self::toString($expand),
                'page' => $page,
                'per-page' => $perPage
            ]
        );
    }

    /**
     * @param $id
     * @param array $expand List of expand parameters
     * @return mappers\MapperInterface|mixed
     */
    public function getById($id, $expand = [])
    {
        $result =  $this->getSingle(
            'company/'.$id,
            'Company',
            [
                'expand' => self::toString($expand)
            ]
        );
        return $result;
    }
}
