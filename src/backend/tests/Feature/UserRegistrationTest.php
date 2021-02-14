<?php

namespace Tests\Feature;

use App\Adapter\WunderfleetPayment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Mockery\MockInterface;
use Spatie\Snapshots\MatchesSnapshots;
use Tests\TestCase;

class UserRegistrationTest extends TestCase
{
    use RefreshDatabase, MatchesSnapshots;

    /**
     * @dataProvider getDifferentInvalidRequests
     */
    public function testThrowingValidationErrors(array $requestBody): void
    {
        $response = $this->postJson('/api/users', $requestBody);
        $this->assertMatchesJsonSnapshot($response->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testSuccessRequest(): void
    {
        /**
         * @var MockInterface $mock
         * to avoid sending real request to 3rd part
         */
        $this->mock(WunderfleetPayment::class, function ($mock) {
            $mock
                ->shouldReceive('getPaymentDataId')
                ->once();
        });

        \Mockery::mock();
        $validRequestBody = [
                'first_name' => 'test Name', 'last_name' => 'test Name', 'telephone' => '123456789123', 'password' => '123456789',
                'address' => ['street' => 'lindemann', 'house_number' => '55', 'zip_code' => '40549', 'city' => 'Cologne'],
                'payment_infos' => ['account_owner' => 'Mohammed', 'iban' => '1234567895']
        ];

        $response = $this->postJson('/api/users', $validRequestBody);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function getDifferentInvalidRequests(): array
    {
        return [
            [
                ['first_name' => 'test Name']
            ],
            [
                ['first_name' => 'test Name', 'last_name' => 'test Name']
            ],
            [
                [
                    'first_name' => 'test Name', 'last_name' => 'test Name', 'telephone' => '1234567587'
                ]
            ],
            [
                [
                    'first_name' => 'test Name', 'last_name' => 'test Name', 'telephone' => '123456789123', 'password' => '123456789'
                ]
            ],
            [
                [
                    'first_name' => 'test Name', 'last_name' => 'test Name', 'telephone' => '123456789123', 'password' => '123456789',
                    'address' => ['street' => 'lindemann']
                ]
            ],
            [
                [
                    'first_name' => 'test Name', 'last_name' => 'test Name', 'telephone' => '123456789123', 'password' => '123456789',
                    'address' => ['street' => 'lindemann', 'house_number' => '55']
                ]
            ],
            [
                [
                    'first_name' => 'test Name', 'last_name' => 'test Name', 'telephone' => '123456789123', 'password' => '123456789',
                    'address' => ['street' => 'lindemann', 'house_number' => '55', 'zip_code' => '40549']
                ]
            ],
            [
                [
                    'first_name' => 'test Name', 'last_name' => 'test Name', 'telephone' => '123456789123', 'password' => '123456789',
                    'address' => ['street' => 'lindemann', 'house_number' => '55', 'zip_code' => '40549', 'city' => 'Cologne']
                ]
            ],
            [
                [
                    'first_name' => 'test Name', 'last_name' => 'test Name', 'telephone' => '123456789123', 'password' => '123456789',
                    'address' => ['street' => 'lindemann', 'house_number' => '55', 'zip_code' => '40549', 'city' => 'Cologne'],
                    'payment_infos' => ['account_owner' => 'Mohammed']
                ]
            ],
        ];
    }
}
