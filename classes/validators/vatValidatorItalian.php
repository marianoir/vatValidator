<?php

include_once  'vatValidatorInterface.php';

class italianVatValidator implements vatValidatorInterface
{
    /**
     * @return array{valid: bool, original: string, corrected: string|null, status: string, description: string}
    */
   public function validate(string $vat): array
    {
        $vat = trim($vat);
        $original = $vat;        
        
        if (preg_match('/^IT\d{11}$/', $vat)) {
            return [
                'valid' => true,
                'original' => $original,
                'corrected' => $vat,
                'isCorrected' => false,
                'status' => 'valid',
                'description' => 'Valid format'
            ];
        }        
       
        if (preg_match('/^\d{11}$/', $vat)) {
            return [
                'valid' => true,
                'original' => $original,
                'corrected' => 'IT' . $vat,
                'isCorrected' => true,
                'status' => 'valid',
                'description' => 'Valid format (Corrected)'
            ];
        }        
        
        if (strlen($vat) === 13 && !preg_match('/^IT\d{11}$/', $vat)) {
            return [
                'valid' => false,
                'original' => $original,
                'corrected' => null,
                'isCorrected' => false,
                'status' => 'invalid',
                'description' => 'Invalid format - must start with IT followed by 11 digits'
            ];
        }        
        
        return [
            'valid' => false,
            'original' => $original,
            'corrected' => null,
            'isCorrected' => false,
            'status' => 'invalid',
            'description' => 'Invalid format - must be 11 digits or IT + 11 digits'
        ];
    }
}