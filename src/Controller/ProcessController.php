<?php

namespace App\Controller;

use App\Entity\Job;
use App\Repository\JobRepository;
use App\Service\Worker;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class ProcessController extends AbstractController
{
    /**
     * @Route("/process", name="process")
     */
    public function initiateRequestCodeFetch(JobRepository $jobRepository, Worker $worker, EntityManagerInterface $em)
    {
        $job = $jobRepository->findOneByStatus('NEW');
        
        $response = $worker->getHttpResponseCode($job);
        $job->setHttpCode($response['code'])->setStatus($response['status']);
        $em->flush();
        

        return $this->render('process/index.html.twig', [
            'process_status' => $response['status'],
            'process_code' => $response['code'],
        ]);
    }
}
