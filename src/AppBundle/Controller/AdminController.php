<?php
namespace AppBundle\Controller;

use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use Symfony\Component\DomCrawler\Crawler;

/**
 *
 */
class AdminController extends BaseAdminController
{
    /**
     * Récupérer l'ABC sur theSession.org
     * @return Response
     */
    public function getAbcAction()
    {
        // change the properties of the given entity and save the changes
        $id = $this->request->query->get('id');
        $tune = $this->em->getRepository('AppBundle:Tune')->find($id);

        $tune = $this->get('tradpractise.the_session_info_service')->updateTuneWithTheSessionInfos($tune);

        $this->em->flush();

        // redirect to the 'list' view of the given entity
        return $this->redirectToRoute('easyadmin', array(
            'action' => 'list',
            'entity' => $this->request->query->get('entity'),
        ));
    }
}
