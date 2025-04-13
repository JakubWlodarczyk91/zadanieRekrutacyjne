<?php

namespace App\Entity;

use App\Repository\CreditRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;

#[ORM\Entity(repositoryClass: CreditRepository::class)]
#[Gedmo\SoftDeleteable(fieldName: "deletedAt", timeAware: false, hardDelete: false)]
class Credit
{
    use SoftDeleteableEntity;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $installment = null;

    #[ORM\Column]
    private ?int $amount = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 4)]
    private ?string $interestRate = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $installmentsAmount = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $installmentsAmountPerYear = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $totalAmount = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $interestAmount = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInstallment(): ?string
    {
        return $this->installment;
    }

    public function setInstallment(string $installment): static
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

    public function getInterestRate(): ?string
    {
        return $this->interestRate;
    }

    public function setInterestRate(string $interestRate): static
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

    public function getTotalAmount(): ?string
    {
        return $this->totalAmount;
    }

    public function setTotalAmount(string $totalAmount): static
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }

    public function getInterestAmount(): ?string
    {
        return $this->interestAmount;
    }

    public function setInterestAmount(string $interestAmount): static
    {
        $this->interestAmount = $interestAmount;

        return $this;
    }
}
