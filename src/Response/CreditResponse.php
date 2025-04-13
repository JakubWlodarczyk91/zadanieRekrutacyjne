<?php

namespace App\Response;

use App\Entity\Credit;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

class CreditResponse
{
    #[Groups(['credit'])]
    #[SerializedName('installment')]
    private float $installment;

    #[Groups(['credit'])]
    #[SerializedName('creditDetails')]
    private CreditDetails $creditDetails;

    #[Groups(['credit'])]
    #[SerializedName('totalAmount')]
    private float $totalAmount;

    #[Groups(['credit'])]
    #[SerializedName('interestAmount')]
    private float $interestAmount;

    #[Groups(['credit'])]
    #[SerializedName('schedule')]
    private array $schedule = [];

    public function __construct(public Credit $credit) {
        $this->installment = $credit->getInstallment();
        $this->creditDetails = new CreditDetails(
            $this->credit->getAmount(),
            $this->credit->getInterestRate(),
            $this->credit->getInstallmentsAmount(),
            $this->credit->getInstallmentsAmountPerYear()
        );
        $this->totalAmount = $this->credit->getTotalAmount();
        $this->interestAmount = $this->credit->getInterestAmount();
        $this->generateSchedule();
    }

    private function generateSchedule(): void
    {
        $interestAmountPerInstalment = ($this->getTotalAmount() - $this->creditDetails->getAmount())/$this->creditDetails->getInstallmentsAmount();
        $capitalAmount = $this->getInstallment() - $interestAmountPerInstalment;

        for ($i = 1; $i <= $this->creditDetails->getInstallmentsAmount(); $i++) {
            $this->schedule[] = new InstallmentScheduleItemResponse(
                $i,
                $this->getInstallment(),
                round($interestAmountPerInstalment, 2),
                round($capitalAmount, 2)
            );
        }
    }

    /**
     * @return float
     */
    public function getInstallment(): float
    {
        return round($this->installment, 2);
    }

    /**
     * @return CreditDetails
     */
    public function getCreditDetails(): CreditDetails
    {
        return $this->creditDetails;
    }

    /**
     * @return float
     */
    public function getTotalAmount(): float
    {
        return round($this->totalAmount, 2);
    }

    /**
     * @return float
     */
    public function getInterestAmount(): float
    {
        return round($this->interestAmount, 2);
    }

    /**
     * @return array
     */
    public function getSchedule(): array
    {
        return $this->schedule;
    }
}