<?php

namespace App\Entity;

use App\Repository\CreditRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use OpenApi\Attributes as OA;

#[ORM\Entity(repositoryClass: CreditRepository::class)]
#[Gedmo\SoftDeleteable(fieldName: "deletedAt", timeAware: false, hardDelete: false)]
#[OA\Schema(schema: "Credit")]
class Credit
{
    use SoftDeleteableEntity;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[OA\Property(type: "integer", example: 17)]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    #[OA\Property(type: "float", example: 691.66)]
    private ?float $installment = null;

    #[ORM\Column]
    #[OA\Property(type: "integer", example: 8000)]
    private ?int $amount = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 4)]
    #[OA\Property(type: "float", example: 0.0685)]
    private ?float $interestRate = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[OA\Property(type: "integer", example: 12)]
    private ?int $installmentsAmount = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[OA\Property(type: "integer", example: 12)]
    private ?int $installmentsAmountPerYear = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    #[OA\Property(type: "float", example: 8299.93)]
    private ?float $totalAmount = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    #[OA\Property(type: "float", example: 299.93)]
    private ?float $interestAmount = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInstallment(): ?float
    {
        return $this->installment;
    }

    public function setInstallment(float $installment): static
    {
        $this->installment = $installment;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getInterestRate(): ?float
    {
        return $this->interestRate;
    }

    public function setInterestRate(float $interestRate): static
    {
        $this->interestRate = $interestRate;

        return $this;
    }

    public function getInstallmentsAmount(): ?int
    {
        return $this->installmentsAmount;
    }

    public function setInstallmentsAmount(int $installmentsAmount): static
    {
        $this->installmentsAmount = $installmentsAmount;

        return $this;
    }

    public function getInstallmentsAmountPerYear(): ?int
    {
        return $this->installmentsAmountPerYear;
    }

    public function setInstallmentsAmountPerYear(int $installmentsAmountPerYear): static
    {
        $this->installmentsAmountPerYear = $installmentsAmountPerYear;

        return $this;
    }

    public function getTotalAmount(): ?float
    {
        return $this->totalAmount;
    }

    public function setTotalAmount(float $totalAmount): static
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }

    public function getInterestAmount(): ?float
    {
        return $this->interestAmount;
    }

    public function setInterestAmount(float $interestAmount): static
    {
        $this->interestAmount = $interestAmount;

        return $this;
    }
}
