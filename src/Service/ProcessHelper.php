<?php

namespace App\Service;
use Symfony\Component\HttpClient\HttpClient;
use App\Entity\Job;
use Doctrine\ORM\EntityManager;
use InvalidArgumentException;
use Symfony\Component\HttpClient\Exception\TransportException;

class ProcessHelper
{
    public function checkHttpResponseCode(Job $job, $em) {
        $job->setStatus('PROCESSING');
        $em->flush();
        $client = HttpClient::create();

        try {
            $response = $client->request('GET', $job->getUrl());
            $status = ['code' => $response->getStatusCode(), 'status' => 'DONE'];
        } catch (InvalidArgumentException $exception) {
            $status = ['code' => null, 'status' => 'ERROR'];
        } catch (TransportException $transportException) {
            $status = ['code' => null, 'status' => 'ERROR'];
        } 

        $job->setHttpCode($status['code'])->setStatus($status['status']);
        $em->flush();

        return $status['status'];
    }
}