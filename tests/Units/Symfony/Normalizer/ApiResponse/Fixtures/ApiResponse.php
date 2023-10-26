<?php

declare(strict_types=1);

namespace App\Tests\Units\Symfony\Normalizer\ApiResponse\Fixtures;

use App\Shared\Domain\Response\ApiResponse as BaseApiResponse;

/**
 * @template T
 * @extends BaseApiResponse<T>
 */
class ApiResponse extends BaseApiResponse
{

}
