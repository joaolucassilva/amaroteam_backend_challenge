<?php

namespace App\Jobs;

use App\Exceptions\ClassNotFoundException;
use App\Services\Products\Import;
use App\Services\S3\S3Service;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ImportProduct implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function handle(): void
    {
        try {
            $s3Service = new S3Service();
            $s3Service->setPath($this->path);

            $format = ucfirst(explode('.', $this->path)[1]);
            $filePath = '\App\Services\Products\\' . $format . 'File';
            if (!class_exists($filePath)) {
                $s3Service->deleteFile();
                throw new ClassNotFoundException('Class Not Exist -> ' . $filePath);
            }

            $import = new Import(new $filePath(), $s3Service->getFile());
            $import->saveProducts();
            $s3Service->deleteFile();
        } catch (ClassNotFoundException $e) {
            Log::debug($e->getMessage(), [
                'pathS3File' => $this->path
            ]);
        }
    }
}
