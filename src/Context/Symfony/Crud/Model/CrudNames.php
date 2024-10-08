<?php

namespace ToolCli\Context\Symfony\Crud\Model;

class CrudNames
{
    private ?string $controllerFilename = '' ;
    private ?string $formFilename = '' ;
    private ?string $indexFilename = 'index' ;
    private ?string $showFilename = 'show' ;
    private ?string $newFilename = 'new' ;
    private ?string $editFilename = 'edit' ;
    private ?string $deleteFilename = '_delete_form' ;
    private ?string $formViewFilename = '_form' ;
    private ?string $capitalName = '' ;
    private ?string $minimalName = '' ;

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->capitalName = ucfirst($name);
        $this->minimalName = lcfirst($name);
        $this->controllerFilename = "{$this->capitalName}Controller";
        $this->formFilename = "{$this->capitalName}Type";
    }

    public function getControllerFilename(): ?string
    {
        return $this->controllerFilename;
    }

    public function getFormFilename(): ?string
    {
        return $this->formFilename;
    }

    public function getCapitalName(): ?string
    {
        return $this->capitalName;
    }

    public function getMinimalName(): ?string
    {
        return $this->minimalName;
    }

    public function getIndexFilename(): ?string
    {
        return $this->indexFilename;
    }

    public function getShowFilename(): ?string
    {
        return $this->showFilename;
    }

    public function getNewFilename(): ?string
    {
        return $this->newFilename;
    }

    public function getEditFilename(): ?string
    {
        return $this->editFilename;
    }

    public function getDeleteFilename(): ?string
    {
        return $this->deleteFilename;
    }

    public function getFormViewFilename(): ?string
    {
        return $this->formViewFilename;
    }

}
