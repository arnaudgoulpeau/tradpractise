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
 * Classe controlleur pour gérer la playlist.
 */
class PlaylistController extends Controller
{
    /**
     * @Route("/playlist", name="playlist")
     * @param Request $request
     * @return type
     */
    public function playlistAction(Request $request)
    {
        $searchTerm = $request->get('search');
        $selectedTag = $request->get('tag');
        $selectedType = $request->get('type');
        $stared = $request->get('stared');

        $entityManager = $this->getDoctrine()->getManager();

        $tags = $this->getDoctrine()->getRepository("AppBundle:Tag")->findAll(array(), array('name' => 'asc'));
        $types = $this->getDoctrine()->getRepository("AppBundle:TuneType")->findAll(array(), array('name' => 'asc'));
        $mp3s = $entityManager->getRepository(\AppBundle\Entity\TuneFile::class)->getAllMp3($searchTerm, $selectedTag, $selectedType, $stared, false);

        return $this->render('playlist/playlist.html.twig', array(
            'mp3s' => $mp3s,
            'tags' => $tags,
            'types' => $types,
            'searchTerm' => $searchTerm,
            'selectedTag' => $selectedTag,
            'selectedType' => $selectedType,
            'stared' => $stared
        ));
    }


    /**
     * @param Request $request
     *
     * @return Response
     * @Route("/tunes", name="search_tunes")
     */
    public function searchTunesAction(Request $request)
    {
        $searchTerm = $request->get('search');
        $selectedTag = $request->get('tag');
        $selectedType = $request->get('type');
        $stared = $request->get('stared');

        $tags = $this->getDoctrine()->getRepository("AppBundle:Tag")->findAll(array(), array('name' => 'asc'));
        $types = $this->getDoctrine()->getRepository("AppBundle:TuneType")->findAll(array(), array('name' => 'asc'));
        $tunes = $this->getDoctrine()->getRepository("AppBundle:Tune")->search($searchTerm, $selectedTag, $selectedType, $stared);

        $viewParams = array(
            'tunes' => $tunes,
            'tags' => $tags,
            'types' => $types,
            'searchTerm' => $searchTerm,
            'selectedTag' => $selectedTag,
            'selectedType' => $selectedType,
            'stared' => $stared,
        );

        return $this->render('tune/tunes.html.twig', $viewParams);
    }
}
