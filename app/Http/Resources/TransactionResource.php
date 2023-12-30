<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'quantity' =>  $this->quantity,
            'buyer' =>  $this->buyer_id,
            'product' => new ProductResource($this->product),
            'creationDate' => $this->created_at,
            'lastChange' => $this->updated_at,
            'deletedDate' => isset($this->deleted_at) ? $this->deleted_at : null,
        ];
    }
}
