<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SeccionResource extends JsonResource
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
            'grade' => (int) ($this->codigo ?? 0),
            'section' => $this->numero,
            'classroom' => $this->aula,
            'teacher' => $this->nombre,
            'schoolYear' => $this->escolari
        ];
    }
}
