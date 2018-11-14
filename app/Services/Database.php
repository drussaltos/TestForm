<?php
namespace App\Services;


use Aura\SqlQuery\QueryFactory;
use PDO;

class Database
{
    private $pdo;
    private $queryFactory;

    public function __construct(PDO $pdo, QueryFactory $queryFactory)
    {
        $this->pdo = $pdo;
        $this->queryFactory = $queryFactory;
    }

    public function create($table,$data)
    {
        $insert = $this->queryFactory->newInsert();
        $insert
            ->into($table)
            ->cols($data);

        $sth = $this->pdo->prepare($insert->getStatement());

        $sth->execute($insert->getBindValues());

        $name = $insert->getLastInsertIdName('id');

        return $this->pdo->lastInsertId($name);
    }
}
