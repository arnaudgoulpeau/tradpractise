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
        $entityManager = $this->getDoctrine()->getManager();
        $mp3s = $entityManager->getRepository(\AppBundle\Entity\TuneFile::class)->getAllMp3(false);

        return $this->render('playlist/playlist.html.twig', array(
            'mp3s' => $mp3s,
        ));
    }
}
