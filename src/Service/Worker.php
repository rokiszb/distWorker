<?php

namespace App\Service;
use Symfony\Component\HttpClient\HttpClient;
use App\Entity\Job;
use InvalidArgumentException;

class Worker
{
    public function getHttpResponseCode(Job $job) {
        $client = HttpClient::create();

        try {
            $response = $client->request('GET', $job->getUrl());
            $reponse = ['code' => $response->getStatusCode(), 'status' => 'DONE'];
        } catch (InvalidArgumentException $exception) {
            $reponse = ['code' => null, 'status' => 'ERROR'];
        }

        return $reponse;
    }
}