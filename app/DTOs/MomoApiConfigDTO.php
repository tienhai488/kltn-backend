<?php

namespace App\DTOs;

class MomoApiConfigDTO
{
    public function __construct(
        public readonly string $endpoint,
        public readonly string $partnerCode,
        public readonly string $accessKey,
        public readonly string $secretKey,
        public readonly string $returnUrl,
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
            endpoint: $data['endpoint'] ?? '',
            partnerCode: $data['partnerCode'] ?? '',
            accessKey: $data['accessKey'] ?? '',
            secretKey: $data['secretKey'] ?? '',
            returnUrl: $data['returnUrl'] ?? '',
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
            'endpoint' => $this->endpoint,
            'partnerCode' => $this->partnerCode,
            'accessKey' => $this->accessKey,
            'secretKey' => $this->secretKey,
            'returnUrl' => $this->returnUrl,
        ];
    }
}
