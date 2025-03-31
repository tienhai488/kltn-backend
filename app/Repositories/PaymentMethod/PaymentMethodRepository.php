<?php

namespace App\Repositories\PaymentMethod;

use App\Enum\ActiveStatus;
use App\Enum\PaymentMethodCode;
use App\Models\PaymentMethod;
use App\Repositories\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

/**
 * The repository for PaymentMethod Model
 */
class PaymentMethodRepository extends BaseRepository implements PaymentMethodRepositoryInterface
{
    const ITEM_PER_PAGE = 50;

    /**
     * {@inheritdoc}
     */
    protected $model;

    /**
     * {@inheritdoc}
     */
    public function __construct(PaymentMethod $model)
    {
        $this->model = $model;
        parent::__construct($model);
    }

    /**
     * @inheritdoc
     */
    public function serverPaginationFilteringForAdmin($searchParams): LengthAwarePaginator
    {
        $limit = Arr::get($searchParams, 'limit', self::ITEM_PER_PAGE);
        $keyword = Arr::get($searchParams, 'search', '');

        $query = $this->model->query();

        if ($keyword) {
            if (is_array($keyword)) {
                $keyword = $keyword['value'];
            }

            $query->whereAny([
                'name',
            ], 'LIKE', '%' . $keyword . '%');
        }

        return $query->latest()->paginate($limit);
    }

    /**
     * {@inheritdoc}
     */
    public function toggleStatus($model)
    {
        try {
            DB::beginTransaction();

            $model->update(['status' => !$model->status->value]);

            DB::commit();

            return $model;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    /**
     * Get active payment methods
     *
     * @return Collection
     */
    public function getActivePaymentMethods(): Collection
    {
        try {
            return $this->model->where('status', ActiveStatus::ACTIVE)
                ->whereIn('code', array_column(PaymentMethodCode::cases(), 'value'))
                ->orderBy('sort_order')
                ->get();
        } catch (\Exception $e) {
            \Log::error('Failed to get active payment methods: ' . $e->getMessage());
            return collect([]);
        }
    }
}
