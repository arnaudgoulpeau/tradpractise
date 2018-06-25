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
 * Classe controlleur pour gérer les techniques.
 */
class TechniqueController extends Controller
{
    /**
     * @param Request $request
     *
     * @return Response
     * @Route("/techniques", name="search_techniques")
     */
    public function searchTechniquesAction(Request $request)
    {
        $searchTerm = $request->get('search');
        $selectedType = $request->get('type');

        $types = $this->getDoctrine()->getRepository("AppBundle:TechniqueType")->findAll(array(), array('name' => 'asc'));
        $techniques = $this->getDoctrine()->getRepository("AppBundle:Technique")->search($searchTerm, $selectedType);

        $viewParams = array(
            'techniques' => $techniques,
            'types' => $types,
            'searchTerm' => $searchTerm,
            'selectedType' => $selectedType,
        );

        return $this->render('technique/techniques.html.twig', $viewParams);
    }
}
