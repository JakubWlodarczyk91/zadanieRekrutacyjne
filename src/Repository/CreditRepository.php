<?php

namespace App\Repository;

use App\Entity\Credit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Credit>
 */
class CreditRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Credit::class);
    }

    public function getLast4(bool $includeDeleted = false): array
    {
        $em = $this->getEntityManager();
        $filters = $em->getFilters();

        if ($includeDeleted) {
            $filters->disable('softdeleteable');
        }

        $result = $this->createQueryBuilder('c')
            ->orderBy('c.interestAmount', 'DESC')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();

        $filters->enable('softdeleteable');

        return $result;
    }

    public function save(Credit $credit)
    {
        $em = $this->getEntityManager();
        $em->persist($credit);
        $em->flush();
    }

    public function delete(Credit $credit)
    {
        $em = $this->getEntityManager();
        $em->remove($credit);
        $em->flush();
    }

    public function deleteById(int $id): bool
    {
        $credit = $this->find($id);

        if (!$credit) {
            return false;
        }

        $this->delete($credit);
        return true;
    }

    public function create(float $amount, float $interestRate, int $installmentsAmount, int $installmentsAmountPerYear, float $installment, float $totalAmount, float $interestAmount): Credit
    {
        return (new Credit())->setAmount($amount)
            ->setInterestRate($interestRate)
            ->setInstallmentsAmount($installmentsAmount)
            ->setInstallmentsAmountPerYear($installmentsAmountPerYear)
            ->setInstallment($installment)
            ->setTotalAmount($totalAmount)
            ->setInterestAmount($interestAmount);
    }
}
