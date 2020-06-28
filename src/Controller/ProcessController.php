<?php

namespace App\Controller;

use App\Repository\JobRepository;
use App\Service\ProcessHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpClient\CurlHttpClient;
use Symfony\Component\HttpClient\Exception\InvalidArgumentException;

class ProcessController extends AbstractController
{
    const MAX_JOBS = 10;

    /**
     * @Route("/start_jobs", name="start_jobs")
     */
    public function initiateMultipleJobRequests(JobRepository $jobRepository, EntityManagerInterface $em, ProcessHelper $processHelper)
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
                // caught exception could be logged later on
                $responses[$job->getId()] = null;
            } 

            $jobArray[$job->getId()] = $job;

            $jobCount++;
        }
        
        $jobArray = $processHelper->updateJobHttpCodes($responses, $jobArray);

        if ($jobCount > 0) $em->flush();

        return new JsonResponse(json_encode(['status' => 'ok']));
    }
}