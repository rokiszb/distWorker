<?php

namespace App\Controller;

use App\Repository\JobRepository;
use App\Service\ProcessHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpClient\CurlHttpClient;
use Symfony\Component\HttpClient\Exception\TransportException;
use Symfony\Component\HttpClient\Exception\InvalidArgumentException;

class ProcessController extends AbstractController
{
    const MAX_JOBS = 4;
    /**
     * @Route("/process", name="process")
     */
    public function initiateRequestCodeFetch(JobRepository $jobRepository, ProcessHelper $processHelper, EntityManagerInterface $em)
    {
        $job = null;
        $response = new JsonResponse();

        if (!empty($job)) {
            $status = $processHelper->checkHttpResponseCode($job, $em);
            $response->setData(['status' => $status]);
        } else {
            $response->setData(['status' => 'Not available']);
        }

        return $response;
    }

    /**
     * @Route("/start_jobs", name="start_jobs")
     */
    public function initiateMultipleJobRequests(JobRepository $jobRepository, ProcessHelper $processHelper, EntityManagerInterface $em)
    {
        $client = new CurlHttpClient();
        
        $responses = [];
        $jobArray = [];
        $jobCount = 0;

        while($jobCount < self::MAX_JOBS) {
            $job = $jobRepository->findOneByStatus('NEW');
            if(empty($job)) break;
            $job->setStatus('PROCESSING');
            $em->flush();

            try {
                $responses[$job->getId()] = $client->request('GET', $job->getUrl());
            } catch (InvalidArgumentException $exception) {
                $responses[$job->getId()] = null;
            } 

            $jobArray[$job->getId()] = $job;

            $jobCount++;
        }
        
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
        $em->flush();
                
        return new JsonResponse(json_encode(['status' => 'ok']));
    }
}

// $job->setStatus('PROCESSING');
// $em->flush();
// $client = HttpClient::create();

// try {
//     $response = $client->request('GET', $job->getUrl());
//     $status = ['code' => $response->getStatusCode(), 'status' => 'DONE'];
// } catch (InvalidArgumentException $exception) {
//     $status = ['code' => null, 'status' => 'ERROR'];
// } catch (TransportException $transportException) {
//     $status = ['code' => null, 'status' => 'ERROR'];
// } 

// $job->setHttpCode($status['code'])->setStatus($status['status']);
// $em->flush();