<?php

namespace App\DTOs;

class BankTransferApiConfigDTO
{
    public function __construct(
        public readonly string $pinCode,
        public readonly string $bankNumber,
        public readonly string $bankName,
        public readonly string $accountName,
        public readonly string $qrImageSrc,
        public readonly string $template,
    ) {
        //
    }

    /**
     * Create a new instance of the DTO from an array of data.
     *
     * @param array $data
     * @return static
     */
    public static function fromArray(array $data): self
    {
        return new self(
            pinCode: $data['pin_code'] ?? '',
            bankNumber: $data['bank_number'] ?? '',
            bankName: $data['bank_name'] ?? '',
            accountName: $data['account_name'] ?? '',
            qrImageSrc: $data['qr_image_src'] ?? '',
            template: $data['template'] ?? '',
        );
    }

    /**
     * Return an array representation of the DTO.
     *
     * @return array<string, string>
     */
    public function toArray(): array
    {
        return [
            'pin_code' => $this->pinCode,
            'bank_number' => $this->bankNumber,
            'bank_name' => $this->bankName,
            'account_name' => $this->accountName,
            'qr_image_src' => $this->qrImageSrc,
            'template' => $this->template,
        ];
    }
}