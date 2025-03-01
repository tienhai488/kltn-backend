<?php

namespace App\Repositories\Setting;

use App\Repositories\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * The repository interface for the Setting Model
 */
interface SettingRepositoryInterface extends RepositoryInterface
{
    /**
     * Summary of findByKey
     *
     * @param string $key
     * @return Model|null
     */
    public function findByKey(string $key): Model|null;

    /**
     * Update by keys.
     */
    public function updateByKeys($data);

    /**
     * Update image.
     *
     * @param Model $model
     * @param $data
     * @param string $collection
     */
    public function updateImage(Model $model, $data, string $collection);

    /**
     * Update images.
     *
     * @param Model $model
     * @param $data
     * @param string $collection
     */
    public function updateImages(Model $model, $data, string $collection);
}
