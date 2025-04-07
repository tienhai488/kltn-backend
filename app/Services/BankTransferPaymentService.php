<?php

namespace App\Services;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class BankTransferPaymentService
{
    protected $bankName;
    protected $accountNumber;
    protected $accountName;
    protected $branch;

    public function __construct()
    {
        $this->bankName = Config::get('payment.bank_transfer.bank_name');
        $this->accountNumber = Config::get('payment.bank_transfer.account_number');
        $this->accountName = Config::get('payment.bank_transfer.account_name');
        $this->branch = Config::get('payment.bank_transfer.branch');
    }

    /**
     * Get bank account information
     */
    public function getBankAccountInfo()
    {
        return [
            'bank_name' => $this->bankName,
            'account_number' => $this->accountNumber,
            'account_name' => $this->accountName,
            'branch' => $this->branch,
        ];
    }

    /**
     * Generate payment instructions
     */
    public function getPaymentInstructions($orderCode)
    {
        return "Vui lòng chuyển khoản đến tài khoản:\n" .
            "Ngân hàng: {$this->bankName}\n" .
            "Số tài khoản: {$this->accountNumber}\n" .
            "Tên tài khoản: {$this->accountName}\n" .
            "Chi nhánh: {$this->branch}\n" .
            "Nội dung: Thanh toán đơn hàng {$orderCode}";
    }

    /**
     * Get the list of banks from VietQR API.
     *
     * @return array
     */
    public function getBanks()
    {
        $response = Http::get('https://api.vietqr.io/v2/banks');

        if ($response->successful()) {
            return $response->json()['data'];
        }

        return [];
    }
}