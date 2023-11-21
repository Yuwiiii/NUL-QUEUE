<?php

namespace MyApp;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Socket implements MessageComponentInterface {

    protected $clients;
    protected $userQueueMapping;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
        $this->userQueueMapping = [];
    }

    public function onOpen(ConnectionInterface $conn) {

        // Store the new connection in $this->clients
        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";
        $this->sendUserQueueMappingData($conn);
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $eventType = json_decode( $msg )->type;

        if($eventType === "setUserToQueue") {
            $userId = json_decode( $msg )->userId;
            $queueNumber = json_decode( $msg )->queueNumber;
            $office = json_decode( $msg )->office;

            $this->userQueueMapping[$userId] = ['queueNumber' => $queueNumber];

            $userId = json_decode($msg)->userId;
            $queueNumber = $this->userQueueMapping[$userId]['queueNumber'];

            print_r($this->userQueueMapping);

            foreach ( $this->clients as $client ) {
                $messageToJson = json_encode( [
                    'type' => 'userQueueMapping',
                    'office' => $office,
                    'data' => $this->userQueueMapping
                ] );
    
                $client->send($messageToJson);
            }
        }else if ($eventType === "notify") {
            $eventType = json_decode( $msg )->type;
            $queue_number = json_decode( $msg )->queue_number;
            $office = json_decode( $msg )->office;

            foreach ( $this->clients as $client ) {
                $messageToJson = json_encode( [
                    'type' => $eventType,
                    'queue_number' => $queue_number,
                    'office' => $office
                ] );
    
                $client->send($messageToJson);
            }
        } else if ($eventType === "newQueue") {
            $eventType = json_decode( $msg )->type;
            $office = json_decode( $msg )->office;

            foreach ( $this->clients as $client ) {
                $messageToJson = json_encode( [
                    'type' => $eventType,
                    'office' => $office
                ] );
    
                $client->send($messageToJson);
            }
        } else if ($eventType === "fetchQueueUponDoneTransaction") {
            $eventType = json_decode( $msg )->type;
            $office = json_decode( $msg )->office;

            foreach ( $this->clients as $client ) {
                $messageToJson = json_encode( [
                    'type' => $eventType,
                    'office' => $office,
                ] );
    
                $client->send($messageToJson);
            }
        } else {
            $eventType = json_decode( $msg )->type;
            $message = json_decode( $msg )->message;
            $recipientOffice = json_decode( $msg )->recipient_office;

            foreach ( $this->clients as $client ) {
                $messageToJson = json_encode( [
                    'type' => $eventType,
                    'message' => $message,
                    'recipient_office' => $recipientOffice
                ] );
    
                $client->send($messageToJson);
            }
        }

        
    }

    public function onClose(ConnectionInterface $conn) {
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
    }

    protected function sendUserQueueMappingData(ConnectionInterface $conn) {
        $data = json_encode(
            [
                'type' => 'userQueueMapping',
                'data' => $this->userQueueMapping
            ]
        );

        $conn->send($data);
    }
}
