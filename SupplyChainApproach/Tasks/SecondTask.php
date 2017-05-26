<?php

namespace SupplyChainApproach\Tasks;


class SecondTask extends AbstractTask
{

    protected $queueName = 'secondTask';

    protected $readFrom = 'firstTaskFinished';

    protected $publishTo = 'secondTaskFinished';

    function process()
    {
        $callback = function ($msg) {
            echo ($this->taskName()." Received : ". $msg->body. "\n");

            $message = json_decode($msg->body, true);

            $message['job'] = [
                'title'   => $this->faker->jobTitle,
                'company' => 'Ets. ' . $this->faker->lastName . ' ' . $this->faker->lastName,
                'city'    => $this->faker->city,
            ];

            $this->publish(json_encode($message));

            echo ($this->taskName()." Published : ". json_encode($message). " on  $this->publishTo \n");
        };

        $this->channel->basic_consume($this->queueName, '', false, true, false, false, $callback);
        while(count($this->channel->callbacks)) {
            $this->channel->wait();
        }

    }

}

