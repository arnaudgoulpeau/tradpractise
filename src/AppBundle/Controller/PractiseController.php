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
 * Classe controlleur pour gérer les entrainements.
 */
class PractiseController extends Controller
{
    /**
     * Liste des entrainements
     * @param Request $request
     *
     * @return Response
     * @Route("/practises", name="search_practises")
     */
    public function practiseAction(Request $request)
    {
        $searchTerm = $request->request->get('search');
        $selectedTag = $request->request->get('tag');
        $practiseSessionList = $this->getDoctrine()->getRepository("AppBundle:PractiseSession")->search($searchTerm, $selectedTag);
        $tags = $this->getDoctrine()->getRepository("AppBundle:Tag")->findAll(array(), array('name' => 'asc'));

        $viewParams = array(
            'practiseSessionList' => $practiseSessionList,
            'tags' => $tags,
            'searchTerm' => $searchTerm,
            'selectedTag' => $selectedTag,
        );

        return $this->render('practise/practises.html.twig', $viewParams);
    }

    /**
     * @param int $id
     *
     * @return Response
     * @Route("/seepractise/{id}", name="seepractise")
     */
    public function seePractiseAction($id)
    {
        $practiseSession = $this->getDoctrine()->getRepository("AppBundle:PractiseSession")->findOneById($id);
        $viewParams = array('practiseSession' => $practiseSession);

        return $this->render('practise/practise_detail.html.twig', $viewParams);
    }
}
