<?php

namespace ToolCli\Context\Symfony\Shared\Enum;

enum ExtensionEnum: string
{
    case Php = '.php';
    case Twig = '.html.twig';
    case None = '';
}
