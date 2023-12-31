<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'identifier' => $this->id,
            'title' => $this->name,
            'description' => $this->description,
            'stock' => $this->quantity,
            'status' => $this->status,
            'image' => url("images/{$this->image}"),
            'seller' => $this->seller_id,
            'creationDate' => $this->created_at,
            'lastChange' => $this->updated_at,
            'deletedDate' => isset($this->deleted_at) ? $this->deleted_at : null,

            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('products.show', $this->id),
                ],
                [
                    'rel' => 'product.buyers',
                    'href' => route('products.buyers.index', $this->id)
                ],
                [
                    'rel' => 'product.categories',
                    'href' => route('products.categories.index', $this->id)
                ],
                [
                    'rel' => 'product.transactions',
                    'href' => route('products.transactions.index', $this->id)
                ],
                [
                    'rel' => 'seller',
                    'href' => route('sellers.show', $this->seller_id)
                ],
            ]
        ];
    }
}
