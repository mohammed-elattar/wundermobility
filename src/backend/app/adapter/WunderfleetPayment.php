<?php

declare(strict_types=1);

namespace App\Adapter;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Psr\Log\LoggerInterface;

class WunderfleetPayment
{
    private const BASE_URL = 'https://37f32cl571.execute-api.eu-central-1.amazonaws.com/default/wunderfleet-recruiting-backend-dev-save-payment-data';
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function getPaymentDataId(array $requestBody): ?string
    {
        try {
            $response = Http::post(self::BASE_URL, $requestBody);
            if (Response::HTTP_OK === $response->status()) {
                $responseBody = json_decode($response->body(), true, 512, JSON_THROW_ON_ERROR);

                return $responseBody['paymentDataId'] ?? null;
            }
        } catch (Exception $exception) {
            $this->logger->error($exception->getMessage(), $exception->getTrace());

            return null;
        }

        $this->logger->error('please check the request body sent', $requestBody);

        return null;
    }
}
