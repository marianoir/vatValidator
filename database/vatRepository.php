<?php

class vatRepository
{   
    private PDO $pdo;
    
    public function __construct(string $host, string $db, string $user, string $pass)
    {
        $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
        $this->pdo = new PDO($dsn, $user, $pass);        
    }

    /*
    * @param array<int, array{client_id: string, vat: string}>>
    */
    public function insertVats(array $vats): void
    {
        $this->clearTable();
        
        $query = $this->pdo->prepare(
            "INSERT INTO vat_numbers (client_id, vat_number) VALUES (?, ?)"
        );
        
        foreach ($vats as $vat) {
            $query->execute([$vat['id'], $vat['vat']]);
        }
    }

    private function clearTable(): void
    {
        $this->pdo->exec("TRUNCATE TABLE vat_numbers");
    }

}