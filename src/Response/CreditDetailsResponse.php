<?php

namespace App\Response;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

class CreditDetails
{
    #[Groups(['creditDetails'])]
    #[SerializedName('amount')]
    private float $amount;

    #[Groups(['creditDetails'])]
    #[SerializedName('interestRate')]
    private float $interestRate;

    #[Groups(['creditDetails'])]
    #[SerializedName('installmentsAmount')]
    private int $installmentsAmount;

    #[Groups(['creditDetails'])]
    #[SerializedName('installmentsAmountPerYear')]
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