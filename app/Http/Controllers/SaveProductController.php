<?php

namespace App\Http\Controllers;

use App\Jobs\ImportProduct;
use App\Services\S3\S3Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\Exception\ExtensionFileException;

class SaveProductController extends Controller
{
    public function __invoke(Request $request, S3Service $s3Service): JsonResponse
    {
        try {
            $s3Service->setFileRequest($request->file('products'))
                ->generatePath()
                ->save();
        } catch (ExtensionFileException $e) {
            report($e);
        }

        ImportProduct::dispatch($s3Service->getPath())->onQueue('import-products');
        return response()->json([], 201);
    }
}
