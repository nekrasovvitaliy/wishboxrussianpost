<?php

declare(strict_types=1);

namespace WishboxRussianPost\Api;

use InvalidArgumentException;
use WishboxRussianPost\Request\Order\OrderUpdateRequestDto;
use WishboxRussianPost\Response\Order\OrderResponseDto;
use WishboxRussianPost\Response\Order\OrderUpdateResponseDto;
use WishboxRussianPost\Validation\Order\CreateOrderRequestValidator;
use WishboxRussianPost\Request\Order\OrderCreateRequestDto;
use WishboxRussianPost\Response\Order\OrderCreateResponseDto;
use WishboxRussianPost\RussianPostClient;
use WishboxRussianPost\Validation\Order\UpdateOrderRequestValidator;

final readonly class OrderApi
{
    private CreateOrderRequestValidator $createOrderValidator;
    private UpdateOrderRequestValidator $updateOrderValidator;

    public function __construct(private RussianPostClient $client)
    {
        $this->createOrderValidator = new CreateOrderRequestValidator();
        $this->updateOrderValidator = new UpdateOrderRequestValidator();
    }

    /**
     * Creates a new order.
     */
    public function create(OrderCreateRequestDto $request): OrderCreateResponseDto
    {
        $this->createOrderValidator->validate($request);

        return $this->client->requestMapped(
            'POST',
            '/1.0/user/backlog',
            [
                202 => OrderCreateResponseDto::class,
            ],
            [],
            $request->toArray()
        );
    }

    /**
     * Returns order details by order UUID.
     */
    public function getById(string $id): OrderResponseDto
    {
        return $this->client->requestMapped(
            'GET',
            '/1.0/backlog/' . $id,
            [
                200 => OrderResponseDto::class
            ]
        );
    }

    /**
     * Updates an existing order.
     */
    public function update(int $id, OrderUpdateRequestDto $request): OrderUpdateResponseDto
    {
        if ($id < 1) {
            throw new InvalidArgumentException('Russian Post order ID must be greater than zero.');
        }

        $this->updateOrderValidator->validate($request);

        return $this->client->requestMapped(
            'PUT',
            '/1.0/backlog/' . $id,
            [
                200 => OrderUpdateResponseDto::class,
            ],
            [],
            $request->toArray()
        );
    }
}
