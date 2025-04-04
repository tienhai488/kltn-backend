<?php

namespace App\Http\Controllers\Api;

use App\Acl\Acl;
use App\Enum\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Repositories\Donation\DonationRepositoryInterface;
use App\Repositories\Project\ProjectRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @tags Thống kê (Statistic)
 */
class StatisticController extends Controller
{
    use ApiResponses;

    public function __construct(
        protected UserRepositoryInterface $userRepository,
        protected ProjectRepositoryInterface $projectRepository,
        protected DonationRepositoryInterface $donationRepository,
    ) {
        //
    }

    /**
     * Thống kê chung.
     *
     * Lấy thông tin thống kê chung.
     *
     * @response array{
     *   organization_count: integer,
     *   individual_count: integer,
     *   user_count: integer,
     *   project_count: integer,
     *   donation_count: integer,
     *   total_donation_amount: float,
     * }
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        return $this->okResponse([
            'organization_count' => $this->userRepository->count(Acl::ROLE_ORGANIZATION),
            'individual_count' => $this->userRepository->count(Acl::ROLE_INDIVIDUAL),
            'user_count' => $this->userRepository->count(),
            'project_count' => $this->projectRepository->count(),
            'donation_count' => $this->donationRepository->advancedGet([
                'conditions' => [
                    'where' => [
                        'status' => PaymentStatus::PAID->value,
                    ],
                ],
            ])->count(),
            'total_donation_amount' => $this->donationRepository->sumAmount(),
        ]);
    }
}
