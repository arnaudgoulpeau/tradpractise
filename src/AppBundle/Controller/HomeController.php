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
 * Classe controlleur pour gérer l'accueil.
 */
class HomeController extends Controller
{
    /**
     * Page d'accueil avec tous les raccourcis et features
     * @param Request $request
     *
     * @return Response
     * @Route("/", name="home")
     */
    public function indexAction(Request $request)
    {

        $tags = $this->getDoctrine()->getRepository("AppBundle:Tag")->findAll(array(), array('name' => 'asc'));
        $types = $this->getDoctrine()->getRepository("AppBundle:TuneType")->findAll(array(), array('name' => 'asc'));

        $viewParams = array(
            'tags' => $tags,
            'types' => $types,
        );

        return $this->render('home/home.html.twig', $viewParams);
    }
}
