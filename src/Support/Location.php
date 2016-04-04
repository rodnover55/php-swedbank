<?php
namespace Rnr\Swedbank\Support;

use Rnr\Swedbank\Config;
use Rnr\Swedbank\Exceptions\ValidationException;
use SimpleXMLElement;

/**
 * @author Sergei Melnikov <me@rnr.name>
 */
class Location
{
    private $address;
    private $city;
    private $zip;
    private $country;
    private $province;

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     * @return Location
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     * @return Location
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * @param mixed $zip
     * @return Location
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     * @return Location
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * @param mixed $province
     * @return Location
     */
    public function setProvince($province)
    {
        $this->province = $province;
        return $this;
    }

    public function getAddressByLines() {
        return StringTool::explode($this->address, Config::LENGTH_ADDRESS);
    }

    public function createElement(SimpleXMLElement $xml) {
        throw new \Exception("Method createElement isn't implemented.");
    }

}