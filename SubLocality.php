<?php
/**
 * Created by PhpStorm.
 * User: sokrat
 * Date: 16.10.14
 * Time: 18:52
 */

namespace consultnn\api;


class SubLocality extends AbstractDomain
{
    public function all()
    {
        return $this->getInternalList(
            'dict2/sublocality',
            'SubLocality',
            [
                'locality' => 172
            ]
        );
    }
} 