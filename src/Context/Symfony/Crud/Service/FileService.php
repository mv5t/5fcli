<?php

namespace ToolCli\Context\Symfony\Crud\Service;

use Exception;
use Symfony\Component\Filesystem\Filesystem;
use ToolCli\Context\Symfony\Crud\Model\CrudNames;
use ToolCli\Context\Symfony\Shared\Enum\DirectoryEnum;
use ToolCli\Context\Symfony\Shared\Enum\ExtensionEnum;

class FileService
{
    public static function fileExist(DirectoryEnum $path, ExtensionEnum $ext, string $name): bool
    {
        $filesystem = new Filesystem();
        return $filesystem->exists("{$path->value}{$name}{$ext->value}");
    }
    public static function dirExist(string $path, string $name): bool
    {
        $filesystem = new Filesystem();
        return $filesystem->exists("{$path}{$name}");
    }
    public static function extractVariable(DirectoryEnum $path, ExtensionEnum $ext, string $name): array
    {
        $fileSystem = new filesystem();
        if (self::fileExist($path, $ext, $name)) {
            $content = $fileSystem->readFile("{$path->value}{$name}{$ext->value}");
            preg_match_all('/\$(\w+) =/', $content, $matches);
            $variableNames = array_unique($matches[1]);
        }
        return $variableNames ?? [];
    }
    public static function createForm(string $name): bool
    {
        $attributes = self::extractVariable(DirectoryEnum::Entity, ExtensionEnum::Php, $name);
        $attributes = array_diff($attributes, ['id']);
        $attributesBuild = self::attributeFormBuilder($attributes);
        try {
            self::saveFile($name, 'type', $attributesBuild, ExtensionEnum::Php);
        } catch (Exception $e) {
            return false;
        }
        return true;
    }
    public static function createController(string $name): bool
    {;
        $attributes = self::extractVariable(DirectoryEnum::Entity, ExtensionEnum::Php, $name);
        $attributesColumns = self::indexColumnsBuilder($attributes);
        try {
            self::saveFile($name, 'controller', $attributesColumns, ExtensionEnum::Php);
        } catch (Exception $e) {
            return false;
        }
        return true;
    }
    public static function createTemplates(string $name): bool
    {
        $attributes = self::extractVariable(DirectoryEnum::Entity, ExtensionEnum::Php, $name);
        $attributes = array_diff($attributes, ['id']);
        $attributesFormView = self::formViewBuilder($attributes);
        $attributesTableShow = self::tableShowBuilder($attributes, $name);
        try {
            self::saveFile($name, 'index', '', ExtensionEnum::Twig);
            self::saveFile($name, 'show', $attributesTableShow, ExtensionEnum::Twig);
            self::saveFile($name, 'new', '', ExtensionEnum::Twig);
            self::saveFile($name, 'edit', '', ExtensionEnum::Twig);
            self::saveFile($name, '_delete_form', '', ExtensionEnum::Twig);
            self::saveFile($name, '_form', $attributesFormView, ExtensionEnum::Twig);

        } catch (Exception $e) {
            return false;
        }
        return true;
    }
    private static function attributeFormBuilder(array $attributes): string
    {
        $ret = '' ;
        foreach ($attributes as $attribute) {
            $ret .= "\t\t\t->add('{$attribute}')\n";
        }
        return $ret;
    }
    private static function indexColumnsBuilder(array $attributes): string
    {
        $ret = '' ;
        foreach ($attributes as $attribute) {
            $ret .= "\t\t\t'" . $attribute . "' => ['label' => '" . ucwords($attribute) . "','sortable' => true,],\n";
        }
        return $ret;
    }
    private static function formViewBuilder(array $attributes): string
    {
        $ret = '' ;
        foreach ($attributes as $attribute) {
            $ret .= "\t\t{{ form_row(form." . $attribute . ") }}\n";
        }
        return $ret;
    }
    private static function tableShowBuilder(array $attributes, string $entity): string
    {
        $ret = '' ;
        foreach ($attributes as $attribute) {
            $ret .= "\t\t\t\t<tr>\n\t\t\t\t\t<th>" . ucwords($attribute) . "</th>\n\t\t\t\t\t<td>{{ " .
                lcfirst($entity) . "." . $attribute . " }}</td>\n\t\t\t\t</tr>\n";
        }
        return $ret;
    }
    private static function tranformContent(string $content, array $params): string
    {
        foreach ($params as $index => $param) {
            $content = str_replace("<%{$index}%>", $param, $content);
        }
        return $content;
    }

    /**
     * @throws Exception
     */
    private static function saveFile(
        string $name,
        string $fileType,
        string $attributes,
        ExtensionEnum $extensionEnum
    ): void
    {
        $filename = dirname(__DIR__, 1) . "/" . DirectoryEnum::FileTemplate->value . $fileType;
        $fileSystem = new filesystem();
        $content = $fileSystem->readFile($filename);
        $crudNames = new CrudNames($name);
        $content = self::tranformContent(
            $content,
            [
                "capitalName" => $crudNames->getCapitalName(),
                "minimalName" => $crudNames->getMinimalName(),
                "controllerFileName" => $crudNames->getControllerFilename(),
                "formFileName" => $crudNames->getFormFilename(),
                "attributes" => $attributes
            ]
        );
        $file = match ($fileType) {
            'type' => $crudNames->getFormFilename(),
            'controller' => $crudNames->getControllerFilename(),
            'index' => $crudNames->getIndexFilename(),
            'show' => $crudNames->getShowFilename(),
            'new' => $crudNames->getNewFilename(),
            'edit' => $crudNames->getEditFilename(),
            '_delete_form' => $crudNames->getDeleteFilename(),
            '_form' => $crudNames->getFormViewFilename(),
            default => throw new Exception('File not found'),
        };
        if ($fileType !== 'controller' && $fileType !== 'type') {
            $directory = DirectoryEnum::Template->value . lcfirst($name) . '/';
        } else {
            $directory = DirectoryEnum::toString(ucfirst($fileType));
        }
        if (!self::dirExist($directory, '')) {
            $fileSystem->mkdir($directory);
        }
        $fileSystem->appendToFile(
            $directory . "{$file}" . $extensionEnum->value,
            $content
        );
    }
}
