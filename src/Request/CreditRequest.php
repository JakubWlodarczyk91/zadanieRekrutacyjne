<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints\DivisibleBy;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use OpenApi\Attributes as OA;

#[OA\Schema(schema: "CreditRequest")]
class CreditRequest
{
    #[NotBlank]
    #[Type(type: "float")]
    #[LessThanOrEqual(value: 12000)]
    #[GreaterThanOrEqual(value: 1000)]
    #[DivisibleBy(value: 500, message: "The credit amount must be divisible by 500.")]
    #[OA\Property(type: "float", example: 8000)]
    protected float $creditAmount;
    #[NotBlank]
    #[Type(type: "float")]
    #[OA\Property(type: "float", example: 6.85)]
    protected float $creditInterestRate;
    #[NotBlank]
    #[Type(type: "int")]
    #[LessThanOrEqual(value: 18)]
    #[GreaterThanOrEqual(value: 3)]
    #[DivisibleBy(value: 3, message: "The installments amount must be divisible by 3.")]
    #[OA\Property(type: "integer", example: 12)]
    protected int $installmentsAmount;
    #[Type(type: "int")]
    #[LessThanOrEqual(value: 12)]
    #[GreaterThanOrEqual(value: 1)]
    #[OA\Property(type: "integer", example: 12)]
    protected int $installmentsAmountPerYear = 12;

    /**
     * @return float|null
     */
    public function getCreditAmount(): ?float
    {
        return $this->creditAmount;
    }

    /**
     * @param float|null $creditAmount
     * @return $this
     */
    public function setCreditAmount(?float $creditAmount): self
    {
        $this->creditAmount = $creditAmount;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getCreditInterestRate(): ?float
    {
        return $this->creditInterestRate;
    }

    /**
     * @param float|null $creditInterestRate
     * @return $this
     */
    public function setCreditInterestRate(?float $creditInterestRate): self
    {
        $this->creditInterestRate = $creditInterestRate;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getInstallmentsAmount(): ?int
    {
        return $this->installmentsAmount;
    }

    /**
     * @param int|null $installmentsAmount
     * @return $this
     */
    public function setInstallmentsAmount(?int $installmentsAmount): self
    {
        $this->installmentsAmount = $installmentsAmount;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getInstallmentsAmountPerYear(): ?int
    {
        return $this->installmentsAmountPerYear;
    }

    /**
     * @param int|null $installmentsAmountPerYear
     * @return $this
     */
    public function setInstallmentsAmountPerYear(?int $installmentsAmountPerYear): self
    {
        $this->installmentsAmountPerYear = $installmentsAmountPerYear;
        return $this;
    }
}