<?php
/**
 * Created by PhpStorm.
 * User: sokrat
 * Date: 31.07.14
 * Time: 20:56
 */

namespace consultnn\api\mappers;


class Company extends AbstractMapper
{
    public $id;
    public $name;
    public $rubrics;
    public $phoneNumbers;
    public $email;
    public $url;
    public $busyHours;
    public $schedule;
    public $address;
    public $sphere;

    /**
     * @var Branch
     */
    public $branch;

    public function setRubric($value)
    {
        $this->rubrics = $value;
    }

    public function setLon($value)
    {
        $this->getAddress()->lon = $value;
    }

    public function setLat($value)
    {
        $this->getAddress()->lat = $value;
    }

    public function setAddressId($value)
    {
        $this->getAddress()->id = $value;
    }

    public function setSublocality($value)
    {
        $this->getAddress()->sub_locality_id = $value;
    }

    public function setAddressName($value)
    {
        $this->getAddress()->name .= $value;
    }

    public function setVillage($value)
    {
        if (!empty($value)) {
            $this->getAddress()->name = $value.', '.$this->getAddress()->name;
        }
    }

    public function setAltHouse($value)
    {
        if (!empty($value)) {
            $this->getAddress()->name = $this->getAddress()->name.'/'.$value;
        }
    }

    public function setBusyhours($value)
    {
        $this->busyHours = $value;
        $schedule = new Schedule();
        $schedule->setBusyHours($value);
        $this->schedule = $schedule->schedule;
    }

    public function setPhonenumbers($value)
    {
        $this->phoneNumbers = $value;
    }

    private function getAddress()
    {
        if (empty($this->address)) {
            $this->address = new Address();
        }

        return $this->address;
    }

    public function setBranchname($value)
    {
        if (!empty($value)) {
            $this->getBranch()->name = $value;
        }
    }

    public function setHeadOfficeId($value)
    {
        if (!empty($value)) {
            $this->getBranch()->headOfficeId = $value;
        }
    }

    /**
     * @return Branch
     */
    private function getBranch()
    {
        if (empty($this->branch)) {
            $this->branch = new Branch();
        }

        return $this->branch;
    }
}
