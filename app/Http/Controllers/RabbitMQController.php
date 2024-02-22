<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitMQController extends Controller
{
    public function send()
    {
        $connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');

        $message = new AMQPMessage('Hello World Queue');

        $channel = $connection->channel();
        $channel->basic_publish($message, 'pdf_events', 'pdf_create');
        $channel->basic_publish($message, 'pdf_events', 'pdf_log');

        $channel->close();
        $connection->close();

        echo "Message published to RabbitMQ \n";
    }

    public function consumer()
    {
        $connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');

        $channel = $connection->channel();

        $callback = function ($msg) {
            Log::info('[x] Received: ', [$msg->getBody()]);
        };

        $channel->basic_consume('pdf_log_queue', '', false, true, false, false, $callback);

        $channel->close();
        $connection->close();
    }
}
