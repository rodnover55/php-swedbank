<?php
namespace Rnr\Swedbank\Populators;


use Rnr\Swedbank\Enums\PageSet;
use Rnr\Swedbank\Enums\SetupMethod;
use Rnr\Swedbank\Enums\TestPageSet;
use Rnr\Swedbank\Exceptions\ValidationException;
use Rnr\Swedbank\Support\EnumTool;
use SimpleXMLElement;

class HpsTxnPopulator extends AbstractPopulator
{
    private $returnUrl;
    private $expiryUrl;
    private $errorUrl;
    private $pageSetId;
    private $visibilityOfCardholderName = true;
    private $goBackUrl;
    private $method = SetupMethod::SIMPLE;

    protected function innerCreateElement(SimpleXMLElement $xml)
    {
        $xml->addChild('method', $this->method);

        $xml->addChild('return_url', $this->returnUrl);
        $xml->addChild('expiry_url', $this->expiryUrl);
        
        if (!empty($this->errorUrl)) {
            $xml->addChild('error_url', $this->errorUrl);
        }
        
        $xml->addChild('page_set_id', $this->pageSetId);

        $dynamicData = $xml->addChild('DynamicData');
        $dynamicData->addChild('dyn_data_3', $this->visibilityOfCardholderName ? 'show' : '');
        $dynamicData->addChild('dyn_data_4', $this->goBackUrl);
    }

    public function check()
    {
        $this->checkUrl($this->returnUrl, "ReturnUrl '{$this->returnUrl}' doesn't has valid format.");
        $this->checkUrl($this->expiryUrl, "ExpiryUrl '{$this->expiryUrl}' doesn't has valid format.");
        $this->checkSsl($this->expiryUrl, "A secure (https) ExpiryUrl must be provided. Got: '{$this->expiryUrl}'");

        if ($this->errorUrl) {
            $this->checkSsl($this->expiryUrl, "A secure (https) ErrorUrl must be provided. Got: '{$this->errorUrl}'");
        }

        $pagesSets = array_merge(array_values(EnumTool::getConstants(PageSet::class)),
            array_values(EnumTool::getConstants(TestPageSet::class)));

        if (!in_array($this->pageSetId, $pagesSets)) {
            throw new ValidationException("Unknown page set id '$this->pageSetId'. " .
                "Please check it or update PageSet or TestPageSet enums.");
        }

        $methods = EnumTool::getConstants(SetupMethod::class);

        if (!in_array($this->method, array_values($methods))) {
            throw new ValidationException("Unknown method '{$this->method}''");
        }
    }

    protected function checkUrl($url, $message = 'Url has not valid format') {
        if (empty($url)) {
            throw new ValidationException($message);
        }
    }

    protected function checkSsl($url, $message = 'A secure (https) URL must be provided.') {
        if (strpos($url, 'https://') !== 0) {
            throw new ValidationException($message);
        }
    }

    /**
     * @return mixed
     */
    public function getReturnUrl()
    {
        return $this->returnUrl;
    }

    /**
     * @param mixed $returnUrl
     * @return $this
     */
    public function setReturnUrl($returnUrl)
    {
        $this->returnUrl = $returnUrl;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getExpiryUrl()
    {
        return $this->expiryUrl;
    }

    /**
     * @param mixed $expiryUrl
     * @return $this
     */
    public function setExpiryUrl($expiryUrl)
    {
        $this->expiryUrl = $expiryUrl;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPageSetId()
    {
        return $this->pageSetId;
    }

    /**
     * @param mixed $pageSetId
     * @return $this
     */
    public function setPageSetId($pageSetId)
    {
        $this->pageSetId = $pageSetId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVisibilityOfCardholderName()
    {
        return $this->visibilityOfCardholderName;
    }

    /**
     * @param mixed $visibilityOfCardholderName
     * @return $this
     */
    public function setVisibilityOfCardholderName($visibilityOfCardholderName)
    {
        $this->visibilityOfCardholderName = $visibilityOfCardholderName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGoBackUrl()
    {
        return $this->goBackUrl;
    }

    /**
     * @param mixed $goBackUrl
     * @return $this
     */
    public function setGoBackUrl($goBackUrl)
    {
        $this->goBackUrl = $goBackUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $method
     * @return $this
     */
    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getErrorUrl()
    {
        return $this->errorUrl;
    }

    /**
     * @param mixed $errorUrl
     * @return $this
     */
    public function setErrorUrl($errorUrl)
    {
        $this->errorUrl = $errorUrl;
        return $this;
    }
}