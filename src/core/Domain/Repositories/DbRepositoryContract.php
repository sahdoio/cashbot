<?php

namespace Core\Domain\Repositories;

use Core\Application\Utils\PaginationDTO;

interface DbRepositoryContract
{
    public function getQueryBuilder();

    public function setSchema(string $schemaClass): void;

    /**
     * Retrieves all records by generic filter
     */
    public function findAll(?array $filter = null, ?int $take = 15, int $page = 1): PaginationDTO;

    /**
     * Retrieves single record by generic filter
     */
    public function findOne(array $filter = []): ?array;

    /**
     * Retrieves a record by its id
     */
    public function findById(int $id): ?array;

    /**
     * @return array|null
     */
    public function create(array $data): array;

    public function update(int $id, array $data): array;

    public function destroy(int $id): bool;
}
