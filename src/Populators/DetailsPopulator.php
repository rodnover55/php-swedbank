<?php
namespace Rnr\Swedbank\Populators;

use Rnr\Swedbank\Config;
use Rnr\Swedbank\Exceptions\ValidationException;
use Rnr\Swedbank\Support\Details;
use Rnr\Swedbank\Support\StringTool;

/**
 * @author Sergei Melnikov <me@rnr.name>
 */
abstract class DetailsPopulator extends AbstractPopulator
{
    /** @var Details */
    protected $details;

    public function __construct(Details $details = null)
    {
        $this->details = $details;
    }

    public function check()
    {
        if (empty($this->details)) {
            throw new ValidationException('Detail is not set.');
        }
        
        if (count($this->explodeAddress()) > 2) {
            throw new ValidationException("Address is too long size.");
        }
    }

    protected function explodeAddress()
    {
        return StringTool::explode($this->details->getLocation()->getAddress(),
            Config::LENGTH_ADDRESS);
    }

    /**
     * @return Details
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @param Details $details
     * @return $this
     */
    public function setDetails($details = null)
    {
        $this->details = $details;
        return $this;
    }
}