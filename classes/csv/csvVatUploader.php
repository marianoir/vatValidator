<?php

class csvVatUploader
{
    /*
    *  @return array<int, <array: {id: string, vat: string}>>
    */
    public static function uploadCsv($file): array
    {
        $vatNumbers = [];
        $file = fopen($file, 'r');		
		while (($line = fgetcsv($file)) !== false) {
			$id = $line[0];	
            $vat = $line[1];
            $vatNumbers[] = [ 'id' => $id, 'vat' => $vat ];			
		}		
		fclose($file);
        return $vatNumbers;
    }

}