<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrginizationAccountReqeustResource extends JsonResource
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
            'name' => $this->name,
            'birth' => customFormatDate($this->birth, 'd/m/Y'),
            'website' => $this->website,
            'field' => $this->field,
            'address' => $this->address,
            'username' => $this->username,
            'information' => $this->information,
            'status_label' => $this->status->getLabel(),
            'status_badge' => $this->status->getBadge(),
            'representative_name' => $this->representative_name,
            'representative_phone_number' => $this->representative_phone_number,
            'representative_email' => $this->representative_email,
        ];
    }
}
