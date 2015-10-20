<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $filename = 'testfile.pdf';
        $basePath = $this->container->getParameter('kernel.root_dir').'/Resources/docs';
        $filePath = $basePath.'/test.pdf';

        $tmpBasePath = $this->container->getParameter('kernel.root_dir').'/Resources/docs-tmp';
        $tmpFilePath = $tmpBasePath.'/test-tmp.pdf';

        file_put_contents($tmpFilePath, file_get_contents($filePath));

        $response = new BinaryFileResponse($tmpFilePath);
        $response->trustXSendfileTypeHeader();
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $filename,
            iconv('UTF-8', 'ASCII//TRANSLIT', $filename)
        );

        return $response;

        // replace this example code with whatever you need
//        return $this->render('default/index.html.twig', array(
//            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
//        ));
    }
}
