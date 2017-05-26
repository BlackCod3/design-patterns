<?php

namespace SupplyChainApproach\Tasks;


use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Faker\Factory;

abstract class AbstractTask
{

    /**
     * @var AMQPStreamConnection
     */
    protected $amqpConnection;

    /**
     * @var AMQPChannel
     */
    protected $channel;

    protected $queueName;

    protected $readFrom;

    protected $publishTo;

    protected $faker;


    abstract function process ();

    function __construct() {

        if (!$this->amqpConnection || !$this->channel) {
            $this->amqpConnection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
            $this->channel        = $this->amqpConnection->channel();
        }

        $this->declareQueue();

        $this->faker = Factory::create('FR_fr');
    }

    protected function declareQueue() {

        if (!$this->channel) {
            throw new \Exception(sprintf('Seems like yourAMQP Connection is down'));
        }

        $this->channel->queue_declare($this->queueName);
        $this->channel->exchange_declare('topic_supply_chain', 'topic', false, false, false);
        $this->channel->queue_bind($this->queueName, 'topic_supply_chain', $this->readFrom);
    }

    protected function publish($content) {
        $this->channel->basic_publish(new AMQPMessage($content), 'topic_supply_chain', $this->publishTo);
    }

    protected function taskName() {
        return basename(str_replace('\\', '/', get_class($this)));
    }

}
