<?php

namespace App\Services\Products;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class XmlFile implements ImportFileInterface
{
    public function execute(string $file)
    {
        $fileInJson = simplexml_load_string($file);
        if (!empty($fileInJson)) {
            foreach ($fileInJson->children() as $product) {
                Product::firstOrCreate(['name' => $product->name], [
                    'id_import' => $product->id,
                    'uuid' => Str::uuid()->toString(),
                    'name' => $product->name,
                    'tags' => json_encode((array)($product->tags->element))
                ]);
            }
            Cache::flush();
        }
    }
}
