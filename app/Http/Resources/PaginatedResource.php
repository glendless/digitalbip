<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\PaginatedResourceResponse;

class PaginatedResource extends JsonResource
{

    public function __construct($resource, public $resourceClass = null)
    {
        parent::__construct($resource);
    }

    public function collect($resource)
    {
        return $this->resourceClass::collection($resource);
    }

    public function toArray($request)
    {
        return [
            'data' => $this->collect($this->resource),
            'meta' => [
                'current_page' => $this->resource->currentPage(),
                'path' => $this->resource->path(),
                'total' => $this->resource->total(),
                'per_page' => $this->resource->perPage(),
                'last_page' => $this->resource->lastPage(),
                'from' => $this->resource->firstItem(),
                'to' => $this->resource->lastItem(),

            ]
        ];
    }


}
