<?php

namespace ToolCli;

class Config
{
    private string $templateDir = __DIR__.'/Template/';

    /**
     * @return string
     */
    public function getTemplateDir(): string
    {
        return $this->templateDir;
    }
}
