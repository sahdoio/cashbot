<?php

namespace Core\Infrastructure\Repositories\Eloquent;

use Core\Application\Utils\PaginationDTO;
use Core\Domain\Repositories\DbRepositoryContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class EloquentDbRepository implements DbRepositoryContract
{
    protected Model $modelObject;

    protected mixed $entity;

    public function setSchema(string $schemaClass): void
    {
        $schema = "App\\Models\\{$schemaClass}";
        $this->modelObject = app($schema);
    }

    /**
     * getModel
     */
    protected function getModel(): Model
    {
        return $this->modelObject;
    }

    public function getQueryBuilder(): Builder
    {
        return $this->modelObject->newQuery();
    }

    /**
     * Retrieves all records from the database
     *
     * @param  array|Builder|null  $filter
     */
    public function findAll($filter = [], ?int $take = 15, int $page = 1): PaginationDTO
    {
        if ($filter instanceof Builder) {
            $query = $filter;
        } elseif (is_array($filter)) {
            $query = $this->getQueryBuilder();
            foreach ($filter as $key => $value) {
                if (is_array($value)) {
                    $query->whereIn($key, $value);
                } else {
                    $query->where($key, $value);
                }
            }
        }

        if (! isset($query)) {
            $query = $this->getQueryBuilder();
        }

        $paginated = $query->paginate(
            $take,
            ['*'],
            'page',
            $page
        );

        return new PaginationDTO(
            $paginated->items(),
            $paginated->total(),
            $paginated->currentPage(),
            $paginated->perPage(),
            $paginated->currentPage() > 1
                ? $paginated->currentPage() - 1
                : null,
            $paginated->currentPage() < $paginated->lastPage()
                ? $paginated->currentPage() + 1
                : null,
            1,
            $paginated->lastPage(),
        );
    }

    /**
     * Retrieves single record by generic filter
     */
    public function findOne(array $filter = []): ?array
    {
        $query = $this->modelObject->newQuery();
        foreach ($filter as $key => $value) {
            if (is_array($value)) {
                $query->whereIn($key, $value);
            } else {
                $query->where($key, $value);
            }
        }
        $result = $query->first();

        return $result ? $result->toArray() : null;
    }

    /**
     * Retrieves a record by its id
     * If parameter $fail is set to true, when something goes wrong
     * the method will fire a ModelNotFoundException.
     *
     * @param  int  $id  *
     */
    public function findById(int $id): ?array
    {
        return $this->findOne(['id' => $id]);
    }

    /**
     * Checks if a record with the given data exists
     */
    public function exist(array $data): bool
    {
        $query = $this->modelObject->newQuery();
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $query->whereIn($key, $value);
            } else {
                $query->where($key, $value);
            }
        }

        return $query->exists();
    }

    public function create(array $data): array
    {
        $entity = $this->modelObject->create($data);

        return $entity->toArray();
    }

    public function update(int $id, array $data): array
    {
        $entity = $this->modelObject->findOrFail($id);

        foreach ($data as $key => $value) {
            $entity->{$key} = $value;
        }

        $entity->save();

        return $entity->toArray();
    }

    public function destroy(int $id): bool
    {
        $entity = $this->modelObject->findOrFail($id);

        return $entity->delete();
    }
}
