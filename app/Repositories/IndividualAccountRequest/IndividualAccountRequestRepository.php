<?php

namespace App\Repositories\IndividualAccountRequest;

use App\Models\IndividualAccountRequest;
use App\Repositories\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

/**
 * The repository for IndividualAccountRequest Model
 */
class IndividualAccountRequestRepository extends BaseRepository implements IndividualAccountRequestRepositoryInterface
{
    const ITEM_PER_PAGE = 50;

    /**
     * {@inheritdoc}
     */
    protected $model;

    /**
     * {@inheritdoc}
     */
    public function __construct(IndividualAccountRequest $model)
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

        $query = $this->individualAccountRequestFilter($searchParams);

        return $query->latest()->paginate($limit);
    }

    /**
     * {@inheritdoc}
     */
    public function individualAccountRequestFilter(array $searchParams): Builder|IndividualAccountRequest
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
                'email',
                'phone_number',
                'birth',
                'club_name',
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

            $individualAccountRequest = $model->update($data);

            DB::commit();

            return $individualAccountRequest;
        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }
    }
}