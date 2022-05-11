<?php
namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'address' => $this->address,
            'country' => $this->country,
            'state' => $this->state,
            'zip_code' => $this->zip_code,
            'birth_date' => $this->birth_date,
            'date_hired' => $this->date_hired
        ];
    }
}
