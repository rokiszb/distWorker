<?php

namespace App\Service;
use Symfony\Component\HttpClient\Exception\TransportException;

class ProcessHelper
{
    public function updateJobHttpCodes(array $responses, array $jobArray)
    {
        foreach ($responses as $rKey => $response) {
            $job = $jobArray[$rKey];
            if (is_null($response)) {
                $job->setStatus('ERROR');
            } else {
                try {
                    $job->setHttpCode($response->getStatusCode());
                    $job->setStatus('DONE');
                } catch (TransportException $transportException) {
                    $job->setStatus('ERROR');
                } 
            }
        }
        return $jobArray;
    }
}