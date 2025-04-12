<?php

namespace App\Tests\Service;

use App\Entity\Credit;
use App\Repository\CreditRepository;
use App\Service\CreditService;
use PHPUnit\Framework\TestCase;

class CreditServiceTest extends TestCase
{
    private CreditRepository $creditRepository;
    private CreditService $creditService;

    protected function setUp(): void
    {
        $this->creditRepository = $this->createMock(CreditRepository::class);
        $this->creditService = new CreditService($this->creditRepository);
    }

    public function testGetLast4()
    {
        $expectedCredits = [
            $this->createMock(Credit::class),
            $this->createMock(Credit::class),
            $this->createMock(Credit::class),
            $this->createMock(Credit::class)
        ];

        $this->creditRepository->expects($this->once())
            ->method('getLast4')
            ->willReturn($expectedCredits);

        $result = $this->creditService->getLast4();
        $this->assertSame($expectedCredits, $result);
    }

    public function testDeleteSuccessful()
    {
        $creditId = 123;

        $this->creditRepository->expects($this->once())
            ->method('deleteById')
            ->with($creditId)
            ->willReturn(true);

        $result = $this->creditService->delete($creditId);
        $this->assertTrue($result);
    }

    public function testDeleteUnsuccessful()
    {
        $nonExistentCreditId = 999;

        $this->creditRepository->expects($this->once())
            ->method('deleteById')
            ->with($nonExistentCreditId)
            ->willReturn(false);

        $result = $this->creditService->delete($nonExistentCreditId);
        $this->assertFalse($result);
    }

    public function testDeleteRepositoryException()
    {
        $creditId = 456;
        $exceptionMessage = "Database connection error";

        $this->creditRepository->expects($this->once())
            ->method('deleteById')
            ->with($creditId)
            ->willThrowException(new \Exception($exceptionMessage));

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage($exceptionMessage);

        $this->creditService->delete($creditId);
    }

    public function testSaveCredit()
    {
        $creditAmount = 10000.0;
        $creditInterestRate = 0.05; // 5%
        $installmentsAmount = 24;
        $installmentsAmountPerYear = 12;

        $expectedInstallment = 438.71389734068595;
        $expectedTotalAmount = $expectedInstallment * $installmentsAmount;
        $expectedInterestAmount = $expectedTotalAmount - $creditAmount;

        $mockCredit = $this->createMock(Credit::class);

        // Act
        $this->creditRepository->expects($this->once())
            ->method('create')
            ->with(
                $creditAmount,
                $creditInterestRate,
                $installmentsAmount,
                $installmentsAmountPerYear,
                $expectedInstallment,
                $expectedTotalAmount,
                $expectedInterestAmount
            )
            ->willReturn($mockCredit);

        $this->creditRepository->expects($this->once())
            ->method('save')
            ->with($mockCredit);

        $result = $this->creditService->saveCredit($creditAmount, $creditInterestRate, $installmentsAmount, $installmentsAmountPerYear);
        $this->assertSame($mockCredit, $result);
    }

    public function testCalculateCreditInstallment()
    {
        $reflectionClass = new \ReflectionClass(CreditService::class);
        $method = $reflectionClass->getMethod('calculateCreditInstallment');
        $method->setAccessible(true);

        $creditAmount = 10000.0;
        $creditInterestRate = 0.05; // 5%
        $installmentsAmount = 16;
        $installmentsAmountPerYear = 12;

        $result = $method->invoke(
            $this->creditService,
            $creditAmount,
            $creditInterestRate,
            $installmentsAmount,
            $installmentsAmountPerYear
        );

        $this->assertEquals(647.37, round($result,2));

        $creditAmount = 12000.0;
        $creditInterestRate = 0.08; // 8%
        $installmentsAmount = 18;
        $installmentsAmountPerYear = 9;

        $result = $method->invoke(
            $this->creditService,
            $creditAmount,
            $creditInterestRate,
            $installmentsAmount,
            $installmentsAmountPerYear
        );

        $this->assertEquals(724.37, round($result,2));

        $creditAmount = 16000.0;
        $creditInterestRate = 0.06; // 6%
        $installmentsAmount = 12;

        $result = $method->invoke(
            $this->creditService,
            $creditAmount,
            $creditInterestRate,
            $installmentsAmount
        );

        $this->assertEquals(1377.06, round($result,2));
    }
}