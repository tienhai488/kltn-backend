<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\SettingResource;
use App\Repositories\Setting\SettingRepositoryInterface;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;

/**
 * @tags Cài đặt (Setting)
 */
class SettingController extends Controller
{
    use ApiResponses;

    public function __construct(
        protected SettingRepositoryInterface $settingRepository,
    ) {
        //
    }

    /**
     * Lấy thông tin.
     *
     * Lấy thông tin theo key.
     * - Chính sách: 'policy'
     * - Điều khoản: 'terms'
     *
     * @response SettingResource
     *
     * @param string $key
     * @return JsonResponse
     */
    public function getValue(string $key)
    {
        $data = $this->settingRepository->findByKey($key);

        if (!$data) {
            return $this->noContentResponse();
        }

        return $this->okResponse(SettingResource::make($data));
    }
}