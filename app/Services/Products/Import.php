<?php

namespace App\Services\Products;

class Import
{
    private ImportFileInterface $importFile;
    private string $file;

    public function __construct(ImportFileInterface $importFile, string $file)
    {
        $this->importFile = $importFile;
        $this->file = $file;
    }

    public function saveProducts()
    {
        $this->importFile->execute($this->file);
    }
}
