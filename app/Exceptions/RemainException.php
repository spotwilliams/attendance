<?php

namespace Cat\Exceptions;


class RemainException extends \Exception
{
    
    protected $uuid;
    
    public function __construct(\Exception $prev, $uuid)
    {
        $this->uuid = $uuid;
        parent::__construct($prev->getMessage(), $prev->getCode(), $prev);
    }
}