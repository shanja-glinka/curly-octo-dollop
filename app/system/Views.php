<?

namespace System;

abstract class Views
{

    protected $responce;

    public function __construct($responce = null)
    {
        $this->responce = $responce;
    }

}
