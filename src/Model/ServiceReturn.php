<?php

namespace ToolCli\Model;

class ServiceReturn
{
    public const SUCCESS = 0;
    public const FAILURE = 1;
    public const INVALID = 2;
    private Int $code;
    private string $text;
    public function __construct(Int $code, string $text){
        $this->code = $code;
        $this->text = $text;
    }

    /**
     * @return Int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }
}
