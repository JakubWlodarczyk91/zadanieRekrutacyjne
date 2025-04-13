<?php

namespace App\Response;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use OpenApi\Attributes as OA;

#[OA\Schema(schema: "InstallmentScheduleItemResponse")]
class InstallmentScheduleItemResponse
{
    #[Groups(['credit'])]
    #[SerializedName('installmentNumber')]
    #[OA\Property(type: "integer", example: 1)]
    private int $installmentNumber;

    #[Groups(['credit'])]
    #[SerializedName('installment')]
    #[OA\Property(type: "float", example: 691.66)]
    private float $installment;

    #[Groups(['credit'])]
    #[SerializedName('interestAmountPerInstalment')]
    #[OA\Property(type: "float", example: 24.99)]
    private float $interestAmountPerInstalment;

    #[Groups(['credit'])]
    #[SerializedName('capitalAmount')]
    #[OA\Property(type: "float", example: 666.67)]
    private float $capitalAmount;

    public function __construct(
        int $installmentNumber,
        float $installment,
        float $interestAmountPerInstalment,
        float $capitalAmount,
    ) {
        $this->installmentNumber = $installmentNumber;
        $this->installment = $installment;
        $this->interestAmountPerInstalment = $interestAmountPerInstalment;
        $this->capitalAmount = $capitalAmount;
    }

    /**
     * @return int
     */
    public function getInstallmentNumber(): int
    {
        return $this->installmentNumber;
    }

    /**
     * @return float
     */
    public function getInstallment(): float
    {
        return $this->installment;
    }

    /**
     * @return float
     */
    public function getInterestAmountPerInstalment(): float
    {
        return $this->interestAmountPerInstalment;
    }

    /**
     * @return float
     */
    public function getCapitalAmount(): float
    {
        return $this->capitalAmount;
    }
}