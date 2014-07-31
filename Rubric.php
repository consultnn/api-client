<?php
/**
 * Created by PhpStorm.
 * User: sokrat
 * Date: 31.07.14
 * Time: 17:49
 */

namespace consultnn\api;


class Rubric extends AbstractDomain
{

    public function all()
    {
        return $this->getInternalList(
            'company/rubricDict',
            'Rubric',
            [
                'pageSize' => 10000,
            ]
        );
    }
}
