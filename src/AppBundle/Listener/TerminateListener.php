<?php

namespace AppBundle\Listener;

use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpKernel\Event\PostResponseEvent;

class TerminateListener
{
    /**
     * @param PostResponseEvent $event
     */
    public function onKernelTerminate(PostResponseEvent $event)
    {
        $response = $event->getResponse();

        if ($response instanceof BinaryFileResponse) {
            $file = $response->getFile();

            if (null !== $file && is_file($file->getPathname())) {
                unlink($file->getPathname());
            }
        }
    }
}
