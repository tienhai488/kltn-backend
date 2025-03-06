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

    /**
     * @inheritdoc
     */
    public function updateImage(Model $model, $data, string $collection)
    {
        try {
            DB::beginTransaction();

            $model->clearMediaCollection($collection);

            if (isset($data) && $data) {
                $file = json_decode($data, true);
                $model->addMediaFromBase64($file['data'])
                    ->usingFileName($file['name'])
                    ->toMediaCollection($collection);
            }

            DB::commit();

            return $model;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    /**
     * @inheritdoc
     */
    public function updateImages(Model $model, $data, string $collection)
    {
        try {
            DB::beginTransaction();

            $model->clearMediaCollection($collection);

            if (isset($data) && $data) {
                foreach ($data as $file) {
                    if (!empty($file)) {
                        $fileDecode = json_decode($file, true);
                        $model->addMediaFromBase64($fileDecode['data'])
                            ->usingFileName($fileDecode['name'])
                            ->toMediaCollection($collection);
                    }
                }
            }

            DB::commit();

            return $model;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
