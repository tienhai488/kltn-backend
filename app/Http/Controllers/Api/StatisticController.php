<?php

namespace App\Http\Controllers\Api;

use App\Acl\Acl;
use App\Enum\PaymentStatus;
use App\Enum\VolunteerStatus;
use App\Http\Controllers\Controller;
use App\Repositories\Donation\DonationRepositoryInterface;
use App\Repositories\Project\ProjectRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Volunteer\VolunteerRepositoryInterface;
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
        protected VolunteerRepositoryInterface $volunteerRepository,
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
     *   volunteer_count: integer,
     * }
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        return $this->okResponse([
            /**
             * Số lượng tổ chức.
             */
            'organization_count' => $this->userRepository->count(Acl::ROLE_ORGANIZATION),
            /**
             * Số lượng cá nhân.
             */
            'individual_count' => $this->userRepository->count(Acl::ROLE_INDIVIDUAL),
            /**
             * Số lượng người dùng.
             */
            'user_count' => $this->userRepository->count(),
            /**
             * Số lượng dự án.
             */
            'project_count' => $this->projectRepository->count(),
            /**
             * Số lượng quyên góp.
             */
            'donation_count' => $this->donationRepository->count(PaymentStatus::PAID->value),
            /**
             * Tổng số tiền quyên góp.
             */
            'total_donation_amount' => $this->donationRepository->sumAmount(),
            /**
             * Tổng số lượt tình nguyện viên.
             */
            'volunteer_count' => $this->volunteerRepository->count(VolunteerStatus::CANCELED->value),
        ]);
    }
}
