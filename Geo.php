<?php

namespace consultnn\api;

class Geo extends AbstractDomain
{
    const TYPE_HOUSE        = 'House';
    const TYPE_SUB_LOCALITY = 'SubLocality';

    public function get($id)
    {
        $result =  $this->getSingle(
            'address2/id',
            [__NAMESPACE__.'\mappers\Geo', 'geoMapResolver'],
            [
                'id' => $id,
                'format' => 'json'
            ]
        );
        return $result;
    }

    /**
     * @param $query
     * @param $types
     * @return mappers\MapperInterface[]
     * @throws exceptions\Exception
     */
    public function search($query, array $types = [], array $filters = [])
    {
        $result =  $this->getInternalList(
            'dict2/address',
            [__NAMESPACE__.'\mappers\Geo', 'geoMapResolver'],
            [
                'name' => $query,
                'format' => 'json',
                'dictionaries' => $types,
                'filters' => $filters
            ]
        );

        return $result;
    }
}