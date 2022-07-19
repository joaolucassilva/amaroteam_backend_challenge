<?php

namespace App\Services\S3;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\Exception\ExtensionFileException;

class S3Service
{
    private ?string $path;
    private ?string $extension;
    private UploadedFile $fileRequest;

    public function save(): void
    {
        Storage::disk('minio')
            ->put(
                $this->getPath(),
                file_get_contents($this->getFileRequest())
            );
    }

    public function getFile(): string
    {
        return Storage::disk('minio')->get($this->getPath());
    }

    public function generatePath(): self
    {
        $this->setExtension($this->fileRequest->getClientOriginalExtension());
        if (empty($this->getExtension())) {
            throw new ExtensionFileException('Formato Arquivo invalido');
        }

        $this->setPath('/payloads/' . date('Ymd') . '/' . Str::uuid()->toString() . '.' . $this->getExtension());
        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath($path): void
    {
        $this->path = $path;
    }

    public function getExtension(): ?string
    {
        return $this->extension;
    }

    public function setExtension($extension): void
    {
        $this->extension = $extension;
    }

    public function getFileRequest(): UploadedFile
    {
        return $this->fileRequest;
    }

    public function setFileRequest(UploadedFile $request): self
    {
        $this->fileRequest = $request;
        return $this;
    }

    public function deleteFile()
    {
        Storage::disk('minio')->delete($this->getPath());
    }
}
