<?php

namespace App\Service;

use App\Entity\Credit;
use App\Repository\CreditRepository;

class CreditService
{
    public function __construct(private CreditRepository $creditRepository){}

    private function calculateCreditInstallment(float $creditAmount, float $creditInterestRate, int $installmentsAmount, int $installmentsAmountPerYear = 12): float
    {
        return $creditAmount*((($creditInterestRate/$installmentsAmountPerYear)*pow(1+($creditInterestRate/$installmentsAmountPerYear), $installmentsAmount))/(pow(1+($creditInterestRate/$installmentsAmountPerYear), $installmentsAmount)-1));
    }

    public function getLast4(bool $includeDeleted = false): array
    {
        return $this->creditRepository->getLast4($includeDeleted);
    }

    public function delete(int $id): bool
    {
        return $this->creditRepository->deleteById($id);
    }

    public function saveCredit(float $creditAmount, float $creditInterestRate, int $installmentsAmount, int $installmentsAmountPerYear): Credit
    {
        $installment = $this->calculateCreditInstallment($creditAmount, $creditInterestRate, $installmentsAmount, $installmentsAmountPerYear);

        $totalAmount = $installment * $installmentsAmount;
        $interestAmount = $totalAmount - $creditAmount;

        $credit = $this->creditRepository->create($creditAmount, $creditInterestRate, $installmentsAmount, $installmentsAmountPerYear, $installment, $totalAmount, $interestAmount);
        $this->creditRepository->save($credit);

        return $credit;
    }
}