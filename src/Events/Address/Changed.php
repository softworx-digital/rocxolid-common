<?php

namespace Softworx\RocXolid\Common\Events\Address;

use Softworx\RocXolid\Http\Responses\Contracts\AjaxResponse;
use Softworx\RocXolid\Common\Models\Address;

class Changed
{
    protected $address;

    protected $response;

    /**
     * Create a new event instance.
     *
     * @param Address $address
     * @return void
     */
    public function __construct(Address $address, AjaxResponse &$response)
    {
        $this->address = $address;
        $this->response = $response;
    }

    /**
     * Retrieve the address model.
     *
     * @return \Softworx\RocXolid\Common\Models\Address
     */
    public function getAddress(): Address
    {
        return $this->address;
    }

    /**
     * Retrieve the response.
     *
     * @return \Softworx\RocXolid\Http\Responses\Contracts\AjaxResponse
     */
    public function getResponse(): AjaxResponse
    {
        return $this->response;
    }
}