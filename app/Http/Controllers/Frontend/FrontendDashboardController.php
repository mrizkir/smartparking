<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Contracts\KafkaConsumerMessage;
use Junges\Kafka\Message;

class FrontendDashboardController extends Controller
{
  public function index(Request $request) {
    $consumer = Kafka::createConsumer()
      ->subscribe(['quickstart-events'])
      ->withHandler(function (KafkaConsumerMessage $message) use (&$key) {
        $key = $message->getKey();
        return 0;
      })
      ->build();
      
    $consumer->consume();
    
    return view('/frontend/welcome');
  }
}