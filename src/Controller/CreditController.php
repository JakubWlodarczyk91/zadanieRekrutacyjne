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
use OpenApi\Attributes as OA;

#[OA\Info(title: "Credit API", version: "1.0.0", description: "Credit API")]
final class CreditController extends AbstractController
{
    public function __construct(
        private CreditService $creditService,
        private SerializerInterface $serializer,
        private ValidatorInterface $validator
    ){}
    #[Route('/credit', name: 'save_credit', methods: ['POST'])]
    #[OA\Post(path: '/credit', operationId: 'save_credit')]
    #[OA\Response(response: '200', description: 'Credit data', content: new OA\JsonContent(ref: '#/components/schemas/CreditResponse'))]
    #[OA\RequestBody(required: true, description: 'Credit input data', content: new OA\JsonContent(ref: '#/components/schemas/CreditRequest'))]
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
    #[OA\Get(path: '/credit/{includedDeleted}', operationId: 'get_credit')]
    #[OA\Response(response: '200', description: 'Last 4 credits with highest interest amount', content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: '#/components/schemas/Credit')))]
    #[OA\Parameter(name: 'includedDeleted', in: 'path', description: 'Include deleted credits', required: false, schema: new OA\Schema(type: 'integer', example: 0))]
    public function get(int $includedDeleted = 0): JsonResponse
    {
        $last4Credits = $this->creditService->getLast4($includedDeleted);

        $jsonContent = $this->serializer->serialize($last4Credits, 'json', [
            'json_encode_options' => JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        ]);

        return new JsonResponse($jsonContent, 200, [], true);
    }

    #[Route('/credit/{id}', name: 'delete_credit', methods: ['DELETE'])]
    #[OA\Get(path: '/credit/{id}', operationId: 'delete_credit')]
    #[OA\Parameter(name: 'id', in: 'path', description: 'Credit id', required: true, schema: new OA\Schema(type: 'integer', example: 17))]
    #[OA\Response(response: '200', description: 'Credit delete information', content: new OA\JsonContent(example: '{ "success": "Credit deleted" }'))]
    #[OA\Response(response: '404', description: 'Credit delete information', content: new OA\JsonContent(example: '{ "error": "Credit not found" }'))]
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
