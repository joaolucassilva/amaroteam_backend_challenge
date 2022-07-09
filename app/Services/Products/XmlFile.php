<?php

namespace App\Services\Products;

use App\Models\Product;
use Illuminate\Support\Str;

class XmlFile implements ImportFileInterface
{
    public function execute(string $file)
    {
        $fileInJson = simplexml_load_string($file);
        if (!empty($fileInJson)) {
            foreach ($fileInJson->children() as $product) {
                Product::create([
                    'id_import' => $product->id,
                    'uuid' => Str::uuid()->toString(),
                    'name' => $product->name,
                    'tags' => json_encode($product->tags->element)
                ]);
            }
        }
    }
}
