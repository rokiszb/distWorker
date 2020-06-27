<?php

namespace App\Controller;

use App\Repository\JobRepository;
use App\Service\ProcessHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;


class ProcessController extends AbstractController
{
    /**
     * v1, this gets the jobs done in non parallel way.
     * @Route("/process", name="process")
     */
    public function initiateRequestCodeFetchV1(JobRepository $jobRepository, ProcessHelper $processHelper, EntityManagerInterface $em)
    {
        $job = $jobRepository->findOneByStatus('NEW');
        $status = $processHelper->checkHttpResponseCode($job, $em);
        
        $response = new JsonResponse();
        $response->setData(['status' => $status]);

        return $response;
    }

    /**
     * @Route("/start_jobs", name="start_jobs")
     */
    public function initiateRequestCodeFetchV2(JobRepository $jobRepository, ProcessHelper $processHelper, EntityManagerInterface $em)
    {

    }
}