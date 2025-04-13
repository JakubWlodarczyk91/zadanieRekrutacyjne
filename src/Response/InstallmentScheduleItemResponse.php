<?php

namespace App\Response;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

class InstallmentScheduleItemResponse
{
    #[Groups(['credit'])]
    #[SerializedName('installmentNumber')]
    private int $installmentNumber;

    #[Groups(['credit'])]
    #[SerializedName('installment')]
    private float $installment;

    #[Groups(['credit'])]
    #[SerializedName('interestAmountPerInstalment')]
    private float $interestAmountPerInstalment;

    #[Groups(['credit'])]
    #[SerializedName('capitalAmount')]
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