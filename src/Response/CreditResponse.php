<?php

namespace App\Response;

use App\Entity\Credit;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use OpenApi\Attributes as OA;

#[OA\Schema(schema: "CreditResponse")]
class CreditResponse
{
    #[Groups(['credit'])]
    #[SerializedName('installment')]
    #[OA\Property(type: "float", example: 691.66)]
    private float $installment;

    #[Groups(['credit'])]
    #[SerializedName('creditDetails')]
    #[OA\Property(ref: "#/components/schemas/CreditDetailsResponse")]
    private CreditDetailsResponse $creditDetails;

    #[Groups(['credit'])]
    #[SerializedName('totalAmount')]
    #[OA\Property(type: "float", example: 8299.93)]
    private float $totalAmount;

    #[Groups(['credit'])]
    #[SerializedName('interestAmount')]
    #[OA\Property(type: "float", example: 299.93)]
    private float $interestAmount;

    #[Groups(['credit'])]
    #[SerializedName('schedule')]
    #[OA\Property(type: "array", items: new OA\Items(ref: "#/components/schemas/InstallmentScheduleItemResponse"))]
    private array $schedule = [];

    public function __construct(public Credit $credit) {
        $this->installment = $credit->getInstallment();
        $this->creditDetails = new CreditDetailsResponse(
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
     * @return CreditDetailsResponse
     */
    public function getCreditDetails(): CreditDetailsResponse
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