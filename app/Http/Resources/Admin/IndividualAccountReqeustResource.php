<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndividualAccountReqeustResource extends JsonResource
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
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'address' => $this->address,
            'club_name' => $this->club_name,
            'website' => $this->website,
            'information' => $this->information,
            'username' => $this->username,
            'status_label' => $this->status->getLabel(),
            'status_badge' => $this->status->getBadge(),
        ];
    }
}