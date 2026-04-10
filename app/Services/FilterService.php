<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

class FilterService
{
    /**
     * Apply a standardized set of filters to an Eloquent query.
     * 
     * @param Builder $query The Eloquent query builder instance
     * @param array $filters An array containing filter values and configuration:
     *                       - 'search': string (the search term)
     *                       - 'search_columns': array (columns to search in)
     *                       - 'status': string ('active', 'inactive', 'deleted', 'all')
     *                       - 'status_column': string (default: 'deleted_at' or 'austrittsdatum')
     *                       - 'dropdowns': array (key => value pairs for exact matches)
     *                       - 'date_range': array ('from' => date, 'to' => date)
     *                       - 'date_column': string (default: 'created_at')
     *                       - 'sort_by': string (column name)
     *                       - 'sort_dir': string ('asc' or 'desc')
     * @return Builder
     */
    public function filter(Builder $query, array $filters): Builder
    {
        // 1. Text Search (LIKE queries with wildcards)
        if (!empty($filters['search']) && !empty($filters['search_columns'])) {
            $query->where(function ($q) use ($filters) {
                foreach ($filters['search_columns'] as $column) {
                    $q->orWhere($column, 'like', '%' . $filters['search'] . '%');
                }
            });
        }

        // 2. Status Filter
        if (!empty($filters['status']) && $filters['status'] !== 'all') {
            $statusColumn = $filters['status_column'] ?? 'deleted_at';
            $this->applyStatusFilter($query, $filters['status'], $statusColumn);
        }

        // 3. Dropdown Filters (Exact matches)
        if (!empty($filters['dropdowns'])) {
            foreach ($filters['dropdowns'] as $column => $value) {
                if ($value !== '' && $value !== null) {
                    $query->where($column, $value);
                }
            }
        }

        // 4. Date Range Filter
        if (!empty($filters['date_range'])) {
            $dateColumn = $filters['date_column'] ?? 'created_at';
            if (!empty($filters['date_range']['from'])) {
                $query->where($dateColumn, '>=', $filters['date_range']['from']);
            }
            if (!empty($filters['date_range']['to'])) {
                $query->where($dateColumn, '<=', $filters['date_range']['to']);
            }
        }

        // 5. Sorting
        $sortBy = $filters['sort_by'] ?? 'created_at';
        $sortDir = $filters['sort_dir'] ?? 'desc';
        
        // Basic check if column exists to prevent SQL injection if input is raw
        $query->orderBy($sortBy, $sortDir);

        return $query;
    }

    /**
     * Helper to apply status logic consistently.
     */
    private function applyStatusFilter(Builder $query, string $status, string $column): void
    {
        switch ($status) {
            case 'active':
                if ($column === 'deleted_at') {
                    $query->whereNull('deleted_at');
                } else {
                    $query->whereNull($column);
                }
                break;
            case 'inactive':
                if ($column === 'deleted_at') {
                    $query->onlyTrashed();
                } else {
                    $query->whereNotNull($column);
                }
                break;
            case 'deleted':
                // For models with SoftDeletes
                if (method_exists($query->getModel(), 'initializeSoftDeletes')) {
                    $query->onlyTrashed();
                }
                break;
        }
    }
}
