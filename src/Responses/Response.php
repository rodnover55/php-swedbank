<?php
namespace Rnr\Swedbank\Responses;
use Rnr\Swedbank\Requests\Request;

/**
 * @author Sergei Melnikov <me@rnr.name>
 */
class Response
{
    /** @var Request */
    private $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }
    
    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }
    
}