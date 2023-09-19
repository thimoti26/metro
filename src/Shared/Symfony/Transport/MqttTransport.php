<?php

declare(strict_types=1);

namespace App\Shared\Symfony\Transport;

use App\ImportBoundedContext\Application\CQRS\Queries\FindGareByFileNameQuery;
use App\ImportBoundedContext\Domain\Model\File\FileNameValueObject;
use PhpMqtt\Client\ConnectionSettings;
use PhpMqtt\Client\Contracts\MqttClient as MqttClientInterface;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\Exceptions\ConfigurationInvalidException;
use PhpMqtt\Client\Exceptions\ConnectingToBrokerFailedException;
use PhpMqtt\Client\Exceptions\DataTransferException;
use PhpMqtt\Client\Exceptions\ProtocolNotSupportedException;
use PhpMqtt\Client\Exceptions\RepositoryException;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\Serialization\PhpSerializer;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Symfony\Component\Messenger\Transport\TransportInterface;


class MqttTransport implements TransportInterface
{
    /** @var MqttClientInterface */
    private readonly MqttClientInterface $client;
    /** @var SerializerInterface */
    private readonly SerializerInterface $serializer;
    /** @var string */
    private static string $topicPatternToSubscribe = '/metro/#';
    /** @var string */
    private static string $topicToPublishTo = 'some/response/topic';

    /**
     * @param array $credentials
     * @param ConnectionSettings $connectionSettings
     * @param array $topics
     * @param SerializerInterface|null $serializer
     * @throws ConfigurationInvalidException
     * @throws ConnectingToBrokerFailedException
     * @throws ProtocolNotSupportedException
     */
    public function __construct(array $credentials, ConnectionSettings $connectionSettings, array $topics, SerializerInterface $serializer = null)
    {
        //Todo topic
        $this->serializer = $serializer ?? new PhpSerializer();

        $this->client = new MqttClient($credentials['host'], $credentials['port'], $credentials['client_id']);
        $this->client->connect($connectionSettings, true);
    }

    /**
     * @return iterable
     */
    public function get(): iterable
    {
        // Store the received messages in some kind of queue. An array should be sufficient for now.
        $queue = [];

        // Subscribe to a topic pattern.
        $this->client->subscribe(self::$topicPatternToSubscribe,
            function (string $topic, string $message, bool $retained) use (&$queue)
            {
                $queue[] = $this->createEnvelope($topic, $message, $retained);
            }, MqttClient::QOS_AT_MOST_ONCE);

        // Manually loop once at a time and then yield all the queued messages.
        $loopStartedAt = microtime(true);
        while (true) {
            $this->client->loopOnce($loopStartedAt, true);

            while (! empty($queue)) {
                $data = array_shift($queue);
                yield $data;
            }
        }
    }

    /**
     * @param string $topic
     * @param string $message
     * @param bool $retained
     * @return Envelope
     */
    public function createEnvelope(string $topic, string $message, bool $retained): Envelope
    {
        $element = null;
        switch ($topic) {
            case '/metro/import/gare':
                $element = new FindGareByFileNameQuery(new FileNameValueObject($message));
                break;
        }
        return new Envelope($element);
    }

    /**
     * @param Envelope $envelope
     * @return Envelope
     * @throws DataTransferException
     * @throws RepositoryException
     */
    public function send(Envelope $envelope): Envelope
    {
        $encodedMessage = $this->serializer->encode($envelope);

        // Only QoS 0 can be used because for other kinds of publishing, looping is required,
        // which blocks the process (temporarily).
        $this->client->publish(self::$topicToPublishTo, implode(':',$encodedMessage));

        return $envelope;
    }

    /**
     * @param Envelope $envelope
     * @return void
     */
    public function ack(Envelope $envelope): void
    {
        // Cannot be implemented in my opinion.
    }

    /**
     * @param Envelope $envelope
     * @return void
     */
    public function reject(Envelope $envelope): void
    {
        // Cannot be implemented in my opinion.
    }
}
