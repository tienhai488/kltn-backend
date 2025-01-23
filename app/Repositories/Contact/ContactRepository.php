<?php

namespace App\Repositories\Contact;

use App\Models\Contact;
use App\Repositories\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

/**
 * The repository for Contact Model
 */
class ContactRepository extends BaseRepository implements ContactRepositoryInterface
{
    const ITEM_PER_PAGE = 50;

    /**
     * {@inheritdoc}
     */
    protected $model;

    /**
     * {@inheritdoc}
     */
    public function __construct(Contact $model)
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

        $query = $this->contactFilter($searchParams);

        return $query->latest()->paginate($limit);
    }

    /**
     * {@inheritdoc}
     */
    public function contactFilter(array $searchParams): Builder|Contact
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
                'subject',
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

            $contact = $model->update($data);

            DB::commit();

            return $contact;
        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function updateMultiple($data): bool
    {
        try {
            DB::beginTransaction();

            $this->model->whereIn('id', $data['contactIds'])->update(['status' => $data['status']]);

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }
    }
}
