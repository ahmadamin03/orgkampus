<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuratResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nomor_surat' => $this->nomor_surat,
            'type' => $this->type,
            'perihal' => $this->perihal,
            'pengirim_penerima' => $this->pengirim_penerima,
            'tanggal' => $this->tanggal,
            'file_path' => $this->file_path,
            'description' => $this->description,
            'organization_id' => $this->organization_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
