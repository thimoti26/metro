<?php

declare(strict_types=1);

namespace App\Shared\Symfony\Transport;

use App\Shared\Exception\InvalidMqttDsnException;
use PhpMqtt\Client\ConnectionSettings;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Symfony\Component\Messenger\Transport\TransportFactoryInterface;
use Symfony\Component\Messenger\Transport\TransportInterface;

class MqttTransportFactory implements TransportFactoryInterface
{
    private array $topics;
    private ?string $clientId;

    /**
     * @param array $topics
     * @param string|null $clientId
     */
    public function __construct(array $topics, ?string $clientId = null)
    {
        $this->topics = $topics;
        $this->clientId = $clientId;
    }

    /**
     * @param string $dsn
     * @param array $options
     * @param SerializerInterface $serializer
     * @return TransportInterface
     */
    public function createTransport(string $dsn, array $options, SerializerInterface $serializer): TransportInterface
    {
        if (false === $parsedUrl = parse_url($dsn)) {
            throw new InvalidMqttDsnException($dsn);
        }

        $pathParts = isset($parsedUrl['path']) ? explode('/', trim($parsedUrl['path'], '/')) : array();

        $credentials = array_replace_recursive(array(
            'host' => $parsedUrl['host'] ?? 'localhost',
            'port' => $parsedUrl['port'] ?? 1883,
            'client_id' => $this->clientId ?? getmypid(),
            'vhost' => isset($pathParts[0]) ? urldecode($pathParts[0]) : '/',
        ), $options);

        $connectionSettings = (new ConnectionSettings())->setPassword($parsedUrl['pass'])->setUsername($parsedUrl['user']);

        return new MqttTransport($credentials, $connectionSettings, $this->topics, $serializer);
    }

    /**
     * @param string $dsn
     * @param array $options
     * @return bool
     */
    public function supports(string $dsn, array $options): bool
    {
        return str_starts_with($dsn, 'mqtt://');
    }

}
