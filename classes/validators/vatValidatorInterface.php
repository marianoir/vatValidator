<?php

interface vatValidatorInterface 
{
    /**
     * @return array{valid: bool, original: string, corrected: string|null, status: string, description: string}
    */
    public function validate(string $vat): array;
}