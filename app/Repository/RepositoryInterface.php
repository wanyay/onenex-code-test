<?php


namespace App\Repository;


use App\Exceptions\DbErrorException;
use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
    /**
     * @return Model
     * @throws DbErrorException
     */
    public function make(): Model;

    /**
     * Begin DB transaction.
     */
    public function beginTransaction(): void;

    /**
     * DB transaction rollback.
     */
    public function rollback(): void;

    /**
     * DB transaction commit.
     */
    public function commit(): void;
}
