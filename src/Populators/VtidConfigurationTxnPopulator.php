<?php
namespace Rnr\Swedbank\Populators;

use Rnr\Swedbank\Enums\ConfigurationMethod;
use Rnr\Swedbank\Exceptions\ValidationException;
use Rnr\Swedbank\Support\EnumTool;
use SimpleXMLElement;

class VtidConfigurationTxnPopulator extends AbstractPopulator
{
    private $method = ConfigurationMethod::VTID;
    private $password;

    protected function innerCreateElement(SimpleXMLElement $xml)
    {
        $xml->addChild('method', $this->method);

        $password = $xml->addChild('Password');
        $password->addChild('new_password', $this->password);
    }

    public function check()
    {
        $methods = array_values(EnumTool::getConstants(ConfigurationMethod::class));

        if (!in_array($this->method, $methods)) {
            throw new ValidationException("Unknown method {$this->method}.");
        }

        if (strlen($this->password) < 8) {
            throw new ValidationException("Password must be more than 8 characters.");
        }

        // TODO: Unimplemented validations:
        // - Made up of a combination of at least 2 of lowercase, uppercase, numeric and special characters.
        // - Dissimilar to the current password.
        // - Not too simplistic or repetitive.
        // - Not contain whole or partial words from the dictionary.
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param mixed $method
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