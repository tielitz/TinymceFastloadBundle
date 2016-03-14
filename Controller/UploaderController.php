<?php

namespace Gwinn\TinymceFastloadBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UploaderController extends Controller
{
    public function uploadAction(Request $request)
    {
        $logger = $this->get('logger');

        $fileOrig = $request->files->get('tiny_inner_image');
        $filePath  = realpath($this->container->getParameter('gwinn_tinymce_fastload.config.upload_path'));
        $logger->debug('TinyMCE file storage directory: '.$filePath);

        $movedFile = $this->get('gwinn_tinymce_fastload.file_mover')->move($fileOrig, $filePath);

        $urlPath = $this->getParameter('gwinn_tinymce_fastload.config.url_path').$movedFile->getFilename();

        // Append domain host and scheme if allowed via configuration
        if ($this->getParameter('gwinn_tinymce_fastload.config.add_host')) {
            $urlPath = $request->getScheme().'://'.$request->getHost().$urlPath;
        }

        $logger->debug('TinyMCE generated image response '.$urlPath);

        $response = new Response('<img src="'.$urlPath.'"/>');
        $response->headers->set('Content-Type', 'text/html');

        return $response;
    }

}
