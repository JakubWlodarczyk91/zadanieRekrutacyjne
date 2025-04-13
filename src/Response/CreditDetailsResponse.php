<?php

namespace App\Response;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use OpenApi\Attributes as OA;

#[OA\Schema(schema: "CreditDetailsResponse")]
class CreditDetailsResponse
{
    #[Groups(['creditDetails'])]
    #[SerializedName('amount')]
    #[OA\Property(type: "float", example: 8000)]
    private float $amount;

    #[Groups(['creditDetails'])]
    #[SerializedName('interestRate')]
    #[OA\Property(type: "float", example: 0.0685)]
    private float $interestRate;

    #[Groups(['creditDetails'])]
    #[SerializedName('installmentsAmount')]
    #[OA\Property(type: "integer", example: 12)]
    private int $installmentsAmount;

    #[Groups(['creditDetails'])]
    #[SerializedName('installmentsAmountPerYear')]
    #[OA\Property(type: "integer", example: 12)]
    private int $installmentsAmountPerYear;

    public function __construct(
        float $amount,
        float $interestRate,
        int $installmentsAmount,
        int $installmentsAmountPerYear
    ) {
        $this->amount = $amount;
        $this->interestRate = $interestRate;
        $this->installmentsAmount = $installmentsAmount;
        $this->installmentsAmountPerYear = $installmentsAmountPerYear;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return float
     */
    public function getInterestRate(): float
    {
        return round($this->interestRate, 4);
    }

    /**
     * @return int
     */
    public function getInstallmentsAmount(): int
    {
        return $this->installmentsAmount;
    }

    /**
     * @return int
     */
    public function getInstallmentsAmountPerYear(): int
    {
        return $this->installmentsAmountPerYear;
    }
}