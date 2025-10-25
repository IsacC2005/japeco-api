<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SeccionDetailResource extends JsonResource
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
            'grade' => $this->codigo,
            'section' => $this->numero,
            'school-year' => $this->escolari,
            'classroom' => $this->aula,
            'teacher' => [],
            'students' => [],
            'schoolYear' => $this->escolari
        ];
    }
}
