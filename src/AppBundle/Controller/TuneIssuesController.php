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
 * Classe controlleur pour gérer les problèmes sur les tunes.
 */
class TuneIssuesController extends Controller
{
    /**
     *
     * @return Response
     * @Route("/tunesissue", name="tunes_issue")
     */
    public function tunesIssueAction()
    {
        $tunes = $this->getDoctrine()->getRepository("AppBundle:Tune")->findForIssues();
        $viewParams = array('tunes' => $tunes);

        return $this->render('tune/tunes_issue.html.twig', $viewParams);
    }
}
