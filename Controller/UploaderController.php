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
        $fileName = time().'-'.$fileOrig->getClientOriginalName();
        $filePath  = realpath($this->container->getParameter('gwinn_tinymce_fastload.upload_path'));

        $logger->debug('TinyMCE file storage directory: '.$filePath);

        if (!file_exists($filePath) && !is_dir($filePath)) {
            $logger->info('TinyMCE creating directory '.$filePath);
            mkdir($filePath);
        }

        $fileOrig->move($filePath, $fileName);

        $logger->debug('TinyMCE image response '.$this->getParameter('gwinn_tinymce_fastload.url_path').$fileName);

        $response = new Response('<img src="'.$this->getParameter('gwinn_tinymce_fastload.url_path') . $fileName . '"/>');
        $response->headers->set('Content-Type', 'text/html');

        return $response;
    }

}
