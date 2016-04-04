<?php
namespace Rnr\Swedbank\Support;

class Details
{
    /** @var Contact */
    private $person;

    /** @var Location */
    private $location;

    /**
     * @return Contact
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * @param mixed $person
     * @return $this
     */
    public function setPerson(Contact $person)
    {
        $this->person = $person;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     * @return $this
     */
    public function setLocation(Location $location)
    {
        $this->location = $location;
        return $this;
    }
}