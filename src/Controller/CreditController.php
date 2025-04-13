<?php

namespace App\Controller;

use App\Request\CreditRequest;
use App\Response\CreditResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Service\CreditService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class CreditController extends AbstractController
{
    public function __construct(
        private CreditService $creditService,
        private SerializerInterface $serializer,
        private ValidatorInterface $validator
    ){}
    #[Route('/credit', name: 'save_credit', methods: ['POST'])]
    public function save(Request $request): JsonResponse
    {
        $creditRequest = $this->serializer->deserialize(
            $request->getContent(),
            CreditRequest::class,
            'json'
        );

        $errors = $this->validator->validate($creditRequest);
        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            return $this->json(['errors' => $errorsString], 400);
        }

        $credit = $this->creditService->saveCredit($creditRequest->getCreditAmount(), $creditRequest->getCreditInterestRate()/100, $creditRequest->getInstallmentsAmount(), $creditRequest->getInstallmentsAmountPerYear());

        $creditResponse = new CreditResponse($credit);

        $jsonContent = $this->serializer->serialize($creditResponse, 'json', [
            'groups' => ['credit', 'creditDetails', 'schedule'],
            'json_encode_options' => JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        ]);

        return new JsonResponse($jsonContent, 200, [], true);
    }

    #[Route('/credit/{includedDeleted}', name: 'get_credit', methods: ['GET'])]
    public function get(int $includedDeleted = 0): JsonResponse
    {
        $last4Credits = $this->creditService->getLast4($includedDeleted);

        $jsonContent = $this->serializer->serialize($last4Credits, 'json', [
            'json_encode_options' => JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        ]);

        return new JsonResponse($jsonContent, 200, [], true);
    }

    #[Route('/credit/{id}', name: 'delete_credit', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $isDeleted = $this->creditService->delete($id);

        $response = ['success' => 'Credit deleted'];
        $status = 200;

        if (!$isDeleted) {
            $response = ['error' => 'Credit not found'];
            $status = 404;
        }

        $jsonContent = $this->serializer->serialize($response, 'json', [
            'json_encode_options' => JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        ]);

        return new JsonResponse($jsonContent, $status, [], true);
    }
}
