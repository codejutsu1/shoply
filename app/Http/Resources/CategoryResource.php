<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'creationDate' => $this->created_at,
            'lastChange' => $this->updated_at,
            'deletedDate' => isset($this->deleted_at) ? $this->deleted_at : null,

            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('categories.show', $this->id),
                ],
                [
                    'rel' => 'categories.buyers',
                    'href' => route('categories.buyers.index', $this->id)
                ],
                [
                    'rel' => 'categories.products',
                    'href' => route('categories.products.index', $this->id)
                ],
                [
                    'rel' => 'categories.sellers',
                    'href' => route('categories.sellers.index', $this->id)
                ],
                [
                    'rel' => 'categories.transactions',
                    'href' => route('categories.transactions.index', $this->id)
                ],
            ]
        ];
    }
}
