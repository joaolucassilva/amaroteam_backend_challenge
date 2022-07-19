<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\ProductSaveRequest;
use App\Jobs\ImportProduct;
use App\Services\S3\S3Service;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\File\Exception\ExtensionFileException;

class SaveProductController extends Controller
{
    public function __invoke(ProductSaveRequest $request, S3Service $s3Service): JsonResponse
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
