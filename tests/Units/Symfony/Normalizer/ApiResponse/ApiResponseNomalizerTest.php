<?php

declare(strict_types=1);

namespace App\Tests\Units\Symfony\Normalizer\ApiResponse;

use App\Shared\Domain\Response\ApiResponse as BaseApiResponse;
use App\Shared\Symfony\Normalizer\ApiResponseNormalizer;
use App\Tests\Units\Symfony\Fixtures\ObjectSerializerNormalizerDenormalizer;
use App\Tests\Units\Symfony\Normalizer\ApiResponse\Fixtures\ApiResponse;
use App\Tests\Units\Symfony\Normalizer\ApiResponse\Fixtures\Content;
use App\Tests\Units\Symfony\Normalizer\ApiResponse\Fixtures\NoApiResponseChild;
use InvalidArgumentException;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use stdClass;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerInterface;

class ApiResponseNomalizerTest extends TestCase
{

    /**
     * @var ApiResponseNormalizer
     */
    private ApiResponseNormalizer $normalizer;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->createNormalizer();
    }

    /**
     * @throws Exception
     */
    private function createNormalizer(): void
    {
        $serializer = $this->createMock(ObjectSerializerNormalizerDenormalizer::class);
        $this->normalizer = new ApiResponseNormalizer();
        $this->normalizer->setSerializer($serializer);
    }

    /**
     * @return void
     * @covers \App\Shared\Symfony\Normalizer\ApiResponseNormalizer::__construct
     */
    public function testConstructor(): void
    {
        $this->assertInstanceOf(AbstractObjectNormalizer::class, $this->normalizer);
        $this->assertInstanceOf(DenormalizerInterface::class, $this->normalizer);
        $this->assertInstanceOf(SerializerAwareInterface::class, $this->normalizer);
    }

    /**
     * @covers \App\Shared\Symfony\Normalizer\ApiResponseNormalizer::setSerializer
     * @return void
     * @throws Exception
     */
    public function testSetSerializerThrowsExceptionIfObjectIsNotInstanceOfDenormalizerInterface(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected a serializer that also implements DenormalizerInterface.');

        /* @var $serializerInterface SerializerInterface */
        $serializerInterface = $this->createMock(SerializerInterface::class);

        $this->normalizer->setSerializer($serializerInterface);
    }

    /**
     * @return void
     * @covers \App\Shared\Symfony\Normalizer\ApiResponseNormalizer::supportsNormalization
     */
    public function testSupportsNormalizationNotSupported(): void
    {
        $this->assertFalse($this->normalizer->supportsNormalization(new BaseApiResponse(1, 'test', null)));
        $this->assertFalse($this->normalizer->supportsNormalization(new NoApiResponseChild()));
        $this->assertFalse($this->normalizer->supportsNormalization(new stdClass()));
        $this->assertFalse($this->normalizer->supportsNormalization([]));
    }

    /**
     * @return void
     * @covers \App\Shared\Symfony\Normalizer\ApiResponseNormalizer::supportsNormalization
     */
    public function testSupportsNormalization(): void
    {
        $this->assertTrue($this->normalizer->supportsNormalization(new ApiResponse(1, 'test', null)));
    }

    /**
     * @return void
     * @covers \App\Shared\Symfony\Normalizer\ApiResponseNormalizer::normalize
     */
    public function testNormalize(): void
    {
        $request = new ApiResponse(
            10,
            'test',
            null,
            200,
        );

        $result = [
            'code' => 10,
            'message' => 'test',
            'content' => null,
            'httpStatusCode' => 200,
            'headers' => null,
        ];


        $this->assertEquals($result, $this->normalizer->normalize($request, 'any'));
    }

    /**
     * @return void
     * @covers \App\Shared\Symfony\Normalizer\ApiResponseNormalizer::supportsDenormalization
     */
    public function testSupportsDenormalizationNotSupported(): void
    {
        $request = [
            'code' => 10,
            'message' => 'test',
            'content' => null,
            'httpStatusCode' => 200,
            'headers' => null,
        ];
        $this->assertFalse($this->normalizer->supportsDenormalization($request, BaseApiResponse::class, 'any'));
        $this->assertFalse($this->normalizer->supportsDenormalization($request, NoApiResponseChild::class, 'any'));
        $this->assertFalse($this->normalizer->supportsDenormalization($request, 'array', 'any'));
        $this->assertFalse($this->normalizer->supportsDenormalization($request, (new stdClass())::class, 'any'));
    }

    /**
     * @return void
     * @covers \App\Shared\Symfony\Normalizer\ApiResponseNormalizer::supportsDenormalization
     */
    public function testSupportsDenormalization(): void
    {
        // Attention le support ne va pas checker le que la subclass soit bien associé au type à dénormaliser
        $request = [
            'code' => 10,
            'message' => 'test',
            'content' => null,
            'httpStatusCode' => 200,
            'headers' => null,
        ];
        $this->assertTrue($this->normalizer->supportsDenormalization($request, ApiResponse::class.'<null>', 'any'));
        $this->assertTrue($this->normalizer->supportsDenormalization($request, ApiResponse::class.'<' . Content::class . '>', 'any'));
    }

    /**
     * @throws ExceptionInterface
     * @covers \App\Shared\Symfony\Normalizer\ApiResponseNormalizer::denormalize
     */
    public function testDenormalizeWithNullContent(): void
    {
        $request = [
            'code' => 10,
            'message' => 'test',
            'content' => null,
            'httpStatusCode' => 200, //Default
            'headers' => ['test' => 'test'], //Default
        ];

        $result = new ApiResponse(
            10,
            'test',
            null,
            200,
            [
                'test' => 'test'
            ]
        );
        $this->assertEquals($result, $this->normalizer->denormalize($request, ApiResponse::class.'<null>', 'any'));
    }

    /**
     * @throws ExceptionInterface|Exception
     * @covers \App\Shared\Symfony\Normalizer\ApiResponseNormalizer::denormalize
     */
    public function testDenormalizeWithEntityContent(): void
    {
        $objectSerializerNormalizerDenormalizer = $this->getMockBuilder(ObjectSerializerNormalizerDenormalizer::class)->getMock();
        $objectSerializerNormalizerDenormalizer
            ->expects($this->any())
            ->method('denormalize')
            ->with(['name' => 'test'], Content::class)
            ->willReturn(new Content('test'));

        /* @var $objectSerializerNormalizerDenormalizer ObjectSerializerNormalizerDenormalizer */

        $this->normalizer->setSerializer($objectSerializerNormalizerDenormalizer);

        $request = [
            'code' => 10,
            'message' => 'test',
            'content' => ['name' => 'test'],
            'httpStatusCode' => 200, //Default
            'headers' => ['test' => 'test'], //Default
        ];

        $result = new ApiResponse(
            10,
            'test',
            new Content('test'),
            200,
            [
                'test' => 'test'
            ]
        );
        $this->assertEquals($result, $this->normalizer->denormalize($request, ApiResponse::class.'<' . Content::class . '>', 'any'));
    }

}
