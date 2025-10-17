<?php

include_once 'vatValidatorInterface.php';

class vatProcessor
{
    private vatValidatorInterface $validator;
    
    public function __construct(vatValidatorInterface $validator)
    {
        $this->validator = $validator;
    }
    
    /**
    * @param array<int, <array: {id: string, vat: string}>> $vats
    * @return array<int,array{id : string, valid: bool, original: string, corrected: string|null, status: string, description: string}>>
    */
    public function validateVats($vats): array
    {
        $vatResults = [];
        $isFirst = true;
        foreach ($vats as $vat)
        {
            if ($isFirst)
            {
                $isFirst = false;
                continue;
            }            
            $validationResult = $this->validator->validate($vat['vat']);
            $validationResult['id'] = $vat['id'];
            $validationResult['vat'] = $vat['vat'];
            $vatResults[] = $validationResult;
        }
        return $vatResults;
    }

}
