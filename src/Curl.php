<?php
namespace Rnr\Swedbank;

use Curl\Curl as BaseCurl;
use Rnr\Swedbank\Exceptions\CurlException;

/**
 * @author Sergei Melnikov <me@rnr.name>
 */
class Curl extends BaseCurl
{
    public function setOptions(array $options) {
        foreach ($options as $option => $value) {
            $this->setOpt($option, $value);
        }
    }

    public function _exec()
    {
        parent::_exec();

        if ($this->error) {
            throw new CurlException($this->curl->error_message, $this->curl->error_code);
        }
    }
}