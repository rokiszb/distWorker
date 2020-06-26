<?php

namespace App\Controller;

use App\Entity\Job;
use App\Repository\JobRepository;
use App\Service\ProcessHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Amp\Parallel\Worker;
use Amp\Promise;
use Amp\Parallel\Worker\CallableTask;
use Amp\Parallel\Worker\DefaultWorkerFactory;

class ProcessController extends AbstractController
{
    /**
     * v1, this gets the jobs done in non parallel way.
     * @Route("/process", name="process")
     */
    public function initiateRequestCodeFetchV1(JobRepository $jobRepository, ProcessHelper $processHelper, EntityManagerInterface $em)
    {
        $jobs = $jobRepository->findManyByStatus('NEW');
        $promises = [];
        foreach ($jobs as $job) {
            $processHelper->checkHttpResponseCode($job, $em);
        }

        return $this->render('process/index.html.twig', [
            'process_count' => count($jobs),
            // 'process_code' => $response['code'],
        ]);
    }

    /**
     * @Route("/processParallel", name="processParallel")
     */
    public function initiateRequestCodeFetchV2(JobRepository $jobRepository, ProcessHelper $processHelper, EntityManagerInterface $em)
    {
        $jobs = $jobRepository->findManyByStatus('NEW');
        $promises = [];
        foreach ($jobs as $job) {
            $processHelper->checkHttpResponseCode($job, $em);
        }

        return $this->render('process/index.html.twig', [
            'process_count' => count($jobs),
            // 'process_code' => $response['code'],
        ]);
    }
}