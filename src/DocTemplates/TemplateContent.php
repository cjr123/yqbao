<?php

namespace Yyk\Eqbao\DocTemplates;

class TemplateContent implements \JsonSerializable
{
    protected $name;
    protected $address;
    protected $phone;
    protected $zip_code;

    public function __construct(string $name, string $address, string $phone, string $zipCode)
    {
        $this->name = $name;
        $this->address = $address;
        $this->phone = $phone;
        $this->zip_code = $zipCode;
    }

    public function jsonSerialize()
    {
        return [
            'name' => $this->name,
            'address' => $this->address,
            'phone' => $this->phone,
            'zip_code' => $this->zip_code
        ];
    }


}