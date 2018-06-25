<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

/**
 * Classe controlleur pour gérer les utilitaires.
 */
class UtilsController extends Controller
{
    /**
     * @Route("/clearcache", name="cacheclear")
     * @param type $messages
     * @return Response
     */
    public function clearcacheAction($messages = 10)
    {
        $kernel = $this->get('kernel');
        $application = new Application($kernel);
        $application->setAutoExit(false);

        $input = new ArrayInput(array('command' => 'cache:clear', '--env' => 'prod'));

        // You can use NullOutput() if you don't need the output
        $output = new BufferedOutput();
        $application->run($input, $output);

        // return the output, don't use if you used NullOutput()
        $content = nl2br($output->fetch());

        // return new Response(""), if you used NullOutput()
        return new Response($content);
    }
}
