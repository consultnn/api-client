<?php

namespace consultnn\api;

class Geo extends AbstractDomain
{
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
}