<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'firstName' => $this->pnombre,
            'secondName' => $this->snombre,
            'firstLastName' => $this->papellido,
            'secondLasName' => $this->sapellido,
            'idcard' => $this->cedula,
            'phone' => $this->tcelular
        ];;
    }
}
