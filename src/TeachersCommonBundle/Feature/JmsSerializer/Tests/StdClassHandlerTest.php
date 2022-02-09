<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\JmsSerializer\Tests;

use JMS\Serializer\SerializerInterface;
use TeachersCommonBundle\Tests\Service\KernelTestCase;

class StdClassHandlerTest extends KernelTestCase
{
    protected SerializerInterface $serializer;

    public function setUp(): void
    {
        parent::setUp();

        self::bootKernel();

        /** @var SerializerInterface $serializer */
        $serializer = self::$container->get(SerializerInterface::class);
        $this->serializer = $serializer;
    }

    public function testDeserialization(): void
    {
        $json = '{"foo":"bar","n":42}';

        $actual = $this->serializer->deserialize($json, \stdClass::class, 'json');

        self::assertEquals(
            json_decode($json, false, 512, \JSON_THROW_ON_ERROR),
            $actual
        );
    }

    public function testEmptyObjectDeserialization(): void
    {
        $json = '{}';

        $actual = $this->serializer->deserialize($json, \stdClass::class, 'json');

        self::assertEquals(
            new \stdClass(),
            $actual
        );
    }

    public function testSerialization(): void
    {
        $json = '{"foo":"bar","n":42}';
        $data = json_decode($json, false, 512, \JSON_THROW_ON_ERROR);
        $actual = $this->serializer->serialize($data, 'json');

        self::assertEquals($json, $actual);
    }
}
