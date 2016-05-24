<?php

namespace InfusionWeb\Laravel\Marketo\Exceptions;

class MarketoDeleteLeadFailed extends MarketoClientException
{
    public function __construct($message = "", $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
