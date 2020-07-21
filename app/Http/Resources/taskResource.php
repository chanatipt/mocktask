<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class taskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
		/* fbsg-signature-addResourceArray:<begin> task */
		return [
			'id' => $this->id,
			'tasktitle' => $this->tasktitle,
			'taskcode' => $this->taskcode,
			'duedate' => $this->duedate,
			'remark' => $this->remark,
			'User' => $this->User,
			'taskStatus' => $this->taskStatus,

			'hasActiveLinkedModels' => $this->hasActiveLinkedModels(),
		];
		/* fbsg-signature-addResourceArray:<end> task */
    }
}
