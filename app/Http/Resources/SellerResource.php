<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SellerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'identifier' =>  $this->id,
            'name' =>  $this->name,
            'email' =>  $this->email,
            'isVerified' => (int) $this->verified,
            'creationDate' => $this->created_at,
            'lastChange' => $this->updated_at,
            'deletedDate' => isset($this->deleted_at) ? $this->deleted_at : null,

            [
                'rel' => 'self',
                'href' => route('sellers.show', $this->id),
            ],
            [
                'rel' => 'seller.categories',
                'href' => route('sellers.categories.index', $this->id)
            ],
            [
                'rel' => 'seller.products',
                'href' => route('sellers.products.index', $this->id)
            ],
            [
                'rel' => 'seller.buyers',
                'href' => route('sellers.buyers.index', $this->id)
            ],
            [
                'rel' => 'seller.transactions',
                'href' => route('sellers.transactions.index', $this->id)
            ],
            [
                'rel' => 'seller.profile',
                'href' => route('users.show', $this->id)
            ],
        ];
    }
}
