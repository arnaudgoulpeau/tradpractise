<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

class ReactController extends Controller
{
    /**
     * Page d'accueil avec tous les raccourcis et features
     * @param Request $request
     *
     * @return Response
     * Route("/react", name="react")
     */
    public function indexAction(Request $request)
    {

        $tags = $this->getDoctrine()->getRepository("AppBundle:Tag")->findAll(array(), array('name' => 'asc'));
        $types = $this->getDoctrine()->getRepository("AppBundle:TuneType")->findAll(array(), array('name' => 'asc'));

        $viewParams = array(
            'tags' => $tags,
            'types' => $types,
        );

        return $this->render('react/react.html.twig', $viewParams);
    }



    /**
     * @Route("/react/{reactRouting}", name="react", defaults={"reactRouting": null})
     */
    public function dashboard(): Response
    {
        return $this->render('react/react.html.twig');
    }
}
