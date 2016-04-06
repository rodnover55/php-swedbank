<?php
namespace Rnr\Swedbank\Populators;


use Rnr\Swedbank\Exceptions\ValidationException;
use SimpleXMLElement;

class ThreeDSecurePopulator extends AbstractPopulator
{
    private $merchantUrl;
    private $description;
    
    protected function innerCreateElement(SimpleXMLElement $xml)
    {
        $xml->addChild('purchase_datetime', date('Ymd h:i:s'));
        // TODO: Discover possible values and system's behavior
        $xml->addChild('verify', 'yes');
        // TODO: Discover possible values
        $xml->addChild('Browser')->addChild('device_category', 0);
        $xml->addChild('merchant_url', $this->merchantUrl);
        $xml->addChild('purchase_desc', $this->description);
    }

    public function check()
    {
        if (empty($this->merchantUrl)) {
            throw new ValidationException('Merchant url is empty');
        }
        
        if (empty($this->description)) {
            throw new ValidationException('Description is empty');
        }
    }

    /**
     * @return mixed
     */
    public function getMerchantUrl()
    {
        return $this->merchantUrl;
    }

    /**
     * @param mixed $merchantUrl
     * @return $this
     */
    public function setMerchantUrl($merchantUrl)
    {
        $this->merchantUrl = $merchantUrl;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }
}