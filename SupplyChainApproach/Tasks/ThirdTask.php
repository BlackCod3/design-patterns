<?php

namespace SupplyChainApproach\Tasks;


class ThirdTask extends AbstractTask
{

    protected $queueName = 'thirdTask';

    protected $readFrom = 'secondTaskFinished';

    protected $publishTo = 'thirdTaskFinished';

    function process()
    {
        $callback = function ($msg) {
            echo ($this->taskName()." Received : ". $msg->body. "\n");

            $message = json_decode($msg->body, true);
            $message['speech'] = [
                $this->faker->paragraph(4),
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

