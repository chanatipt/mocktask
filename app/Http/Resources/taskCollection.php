<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class taskCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
		/* fbsg-signature-addResourceCollection:<begin> task */
		return [
			'data' => taskResource::collection($this->collection),
			'meta' => ''
		];
		/* fbsg-signature-addResourceCollection:<end> task */
    }
}
