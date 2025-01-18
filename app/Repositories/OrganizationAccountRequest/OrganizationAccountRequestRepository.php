<?php

namespace App\Repositories\OrganizationAccountRequest;

use App\Models\OrganizationAccountRequest;
use App\Repositories\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

/**
 * The repository for OrganizationAccountRequest Model
 */
class OrganizationAccountRequestRepository extends BaseRepository implements OrganizationAccountRequestRepositoryInterface
{
    const ITEM_PER_PAGE = 50;

    /**
     * {@inheritdoc}
     */
    protected $model;

    /**
     * {@inheritdoc}
     */
    public function __construct(OrganizationAccountRequest $model)
    {
        $this->model = $model;
        parent::__construct($model);
    }

    /**
     * {@inheritdoc}
     */
    public function serverPaginationFilteringForAdmin($searchParams): LengthAwarePaginator
    {
        $limit = Arr::get($searchParams, 'limit', self::ITEM_PER_PAGE);

        $query = $this->organizationAccountRequestFilter($searchParams);

        return $query->latest()->paginate($limit);
    }

    /**
     * {@inheritdoc}
     */
    public function organizationAccountRequestFilter(array $searchParams): Builder|OrganizationAccountRequest
    {
        $keyword = Arr::get($searchParams, 'search', '');
        $status = Arr::get($searchParams, 'status', null);

        $query = $this->model->query();

        if ($keyword) {
            if (is_array($keyword)) {
                $keyword = $keyword['value'];
            }

            $query->whereAny([
                'name',
                'birth',
                'field',
                'representative_name',
                'representative_phone_number',
                'representative_email',
            ], 'LIKE', '%' . $keyword . '%');
        }

        if (! is_null($status)) {
            $query->where('status', $status);
        }

        return $query;
    }

    /**
     * {@inheritdoc}
     */
    public function update($model, $data)
    {
        try {
            DB::beginTransaction();

            $organizationAccountRequest = $model->update($data);

            DB::commit();

            return $organizationAccountRequest;
        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }
    }
}