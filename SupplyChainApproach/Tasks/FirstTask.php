<?php

namespace SupplyChainApproach\Tasks;


class FirstTask extends AbstractTask
{

    protected $queueName = 'firstTask';

    protected $readFrom = 'event_0';

    protected $publishTo = 'firstTaskFinished';

    function process()
    {
        $callback = function ($msg) {
            echo ($this->taskName()." Received : ". $msg->body. "\n");

            $message = json_decode($msg->body, true);

            $firstName = rand()%2 ? $this->faker->firstNameFemale  :$this->faker->firstNameMale;
            $lastName = $this->faker->lastName;
            $email = strtolower($firstName.".".$lastName)."@".$this->faker->freeEmailDomain;

            $message['identity'] = [
                'firstName' => $firstName,
                'lastName'  => $lastName,
                'email'     => $email,
                'birthDate' => $this->faker->date($format = 'Y-m-d', $max = '-20 years'),
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

