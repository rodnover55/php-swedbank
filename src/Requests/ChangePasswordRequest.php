<?php
namespace Rnr\Swedbank\Requests;

use Rnr\Swedbank\Populators\MerchantReferencePopulator;
use Rnr\Swedbank\Populators\VtidConfigurationTxnPopulator;
use Rnr\Swedbank\Responses\ChangePasswordResponse;
use Rnr\Swedbank\Support\MerchantReference;
use SimpleXMLElement;

class ChangePasswordRequest extends Request
{
    private $password;

    protected function fillTransaction(SimpleXMLElement $xml)
    {
        $referencePopulator = new MerchantReferencePopulator(new MerchantReference('ChangePassword', uniqid()));

        $configurationPopulator = new VtidConfigurationTxnPopulator();
        $configurationPopulator->setPassword($this->password);

        $referencePopulator->createElement($xml->addChild('TxnDetails'));
        $configurationPopulator->createElement($xml->addChild('VtidConfigurationTxn'));
    }

    protected function createResponse(SimpleXMLElement $response)
    {
        return new ChangePasswordResponse($response, $this);
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }
}