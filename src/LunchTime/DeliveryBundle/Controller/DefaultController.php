<?php

namespace LunchTime\DeliveryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;

use LunchTime\DeliveryBundle\Entity\Client;
use LunchTime\DeliveryBundle\Controller\Base\BaseController;

class DefaultController extends BaseController
{
    //TODO: move to company controller

    /**
     * @Route("/")
     * @Template()
     */
    public function homeAction()
    {
        $em = $this->getEntityManager();

        $menus = $em->getRepository('LTDeliveryBundle:Menu')->getListWithItemsQuery()
            ->getResult();

        $orders = $em->getRepository('LTDeliveryBundle:Client\Order')->getListWithItemsQuery()
            ->getResult();

        return array(
            'menus'  => $menus,
            'orders' => $orders,
        );
    }

    /**
     * @Route(pattern="/company/{token}", name="companyPage")
     * @Template()
     */
    public function companyAction($token)
    {
        $company = $this->getCompany($token);

        return array(
            'company' => $company,
        );

    }

    /**
     * @Route(pattern="/client/{token}", name="clientPage")
     * @Template()
     */
    public function clientAction($token)
    {
        $client = $this->getClient($token);

        return array(
            'client' => $client,
            'menus'  => $this->getMenus(),
            'orders' => $client->getOrders(),

        );

    }

    /**
     * @Route(pattern="/company/{token}/signup", name="signup")
     */
    public function signup($token)
    {
        $em = $this->getEntityManager();

        //expecting array {client: [name, email]}
        $data = $this->getRequest()->get('client');
        $data = array_merge($data, array('company' => $this->getCompany($token)));

        $client = $this->mapClient($data);
        $em->persist($client);
        $em->flush();

        //TODO: redirect to client page
        return $this->redirect($this->generateUrl('clientPage', array(
            'token' => $client->getToken(),
        )));
    }

}
