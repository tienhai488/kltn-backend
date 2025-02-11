<?php

namespace App\Repositories\Setting;

use App\Models\Setting;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

/**
 * The repository for Setting Model
 */
class SettingRepository extends BaseRepository implements SettingRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    protected $model;

    /**
     * {@inheritdoc}
     */
    public function __construct(Setting $model)
    {
        $this->model = $model;
        parent::__construct($model);
    }

    /**
     * Summary of findByKey
     */
    public function findByKey(string $key): ?Model
    {
        return $this->model->where('key', $key)->first();
    }

    /**
     * {@inheritdoc}
     */
    public function updateByKeys($data)
    {
        try {
            DB::beginTransaction();

            foreach ($data as $key => $value) {
                $result = $this->model->where('key', $key)->update(['value' => $value]);
                if ($result) {
                    $this->updateCache($key, $value);
                }
            }

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            return $e->getMessage();
        }
    }

    /**
     * Update caching for better performances
     *
     * @param $key
     * @param $value
     * @return void
     */
    private function updateCache($key, $value): void
    {
        Cache::forget('setting_' . $key);
        Cache::rememberForever('setting_' . $key, fn() => $value);
    }
}