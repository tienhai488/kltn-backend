<?php

namespace App\DTOs;

class VNPayApiConfigDTO
{
    public function __construct(
        public readonly string $vnpTmnCode,
        public readonly string $vnpHashSecret,
        public readonly string $vnpUrl,
        public readonly string $vnpReturnUrl,
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
            vnpTmnCode: $data['vnpTmnCode'] ?? '',
            vnpHashSecret: $data['vnpHashSecret'] ?? '',
            vnpUrl: $data['vnpUrl'] ?? '',
            vnpReturnUrl: $data['vnpReturnUrl'] ?? '',
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
            'vnpTmnCode' => $this->vnpTmnCode,
            'vnpHashSecret' => $this->vnpHashSecret,
            'vnpUrl' => $this->vnpUrl,
            'vnpReturnUrl' => $this->vnpReturnUrl,
        ];
    }
}