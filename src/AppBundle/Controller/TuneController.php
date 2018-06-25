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
 * Classe controlleur pour gérer les tunes.
 */
class TuneController extends Controller
{
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

    /**
     * @Route("/newtune", name="newtune")
     * @param Request $request
     * @return type
     */
    public function newAction(Request $request)
    {
        $tune = new \AppBundle\Entity\Tune();

        $form = $this->createForm(new \AppBundle\Form\TuneType(), $tune);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tune = $form->getData();

            $tune = $this->get('tradpractise.the_session_info_service')->updateTuneWithTheSessionInfos($tune);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tune);
            $entityManager->flush();
        }

        return $this->render('tune/new_tune.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/edittune", name="edittune")
     * @param type    $id
     * @param Request $request
     * @return type
     * @throws type
     */
    public function editAction($id, Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $tune = $entityManager->getRepository(\AppBundle\Entity\Tune::class)->find($id);

        if (!$tune) {
            throw $this->createNotFoundException('No tune found for id '.$id);
        }

        $originalTuneFiles = new ArrayCollection();

        // Create an ArrayCollection of the current Tag objects in the database
        foreach ($tune->getTuneFiles() as $tuneFile) {
            $originalTuneFiles->add($tuneFile);
        }

        $editForm = $this->createForm(new \AppBundle\Form\TuneType(), $tune);

        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            // remove the relationship between the tuneFile and the Tune
            foreach ($originalTuneFiles as $tuneFile) {
                if (false === $tune->getTuneFiles()->contains($tuneFile)) {
                    $entityManager->remove($tuneFile);
                }
            }

            $entityManager->persist($tune);
            $entityManager->flush();

            // redirect back to some edit page
            return $this->redirectToRoute('home');
        }

        return $this->render('tune/edit_tune.html.twig', array(
            'form' => $editForm->createView(),
        ));

    }
}
