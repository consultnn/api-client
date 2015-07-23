<?php

namespace consultnn\api;

class Geo extends AbstractDomain
{
    const TYPE_HOUSE        = 'house';
    const TYPE_SUB_LOCALITY = 'sublocality';

    public function get($id)
    {
        $result =  $this->getSingle(
            'address/id',
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
    public function search($query, $types = [])
    {
        $result =  $this->getInternalList(
            'dict/address',
            [__NAMESPACE__.'\mappers\Geo', 'geoMapResolver'],
            [
                'name' => $query,
                'format' => 'json',
                'dictionaries' => $types
            ]
        );
        return $result;
    }
}