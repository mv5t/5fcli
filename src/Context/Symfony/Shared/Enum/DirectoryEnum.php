<?php

namespace ToolCli\Context\Symfony\Shared\Enum;

enum DirectoryEnum: string
{
    case Template = 'templates/' ;
    case Entity = 'src/Entity/' ;
    case Type = 'src/Form/' ;
    case Controller = 'src/Controller/' ;
    case FileTemplate = 'template/' ;
    public static function toString(string $index): string
    {
        foreach (self::cases() as $case) {
            if ($case->name === $index) {
                return $case->value;
            }
        }
        throw new \InvalidArgumentException("Invalid value {$index}");
    }
}
