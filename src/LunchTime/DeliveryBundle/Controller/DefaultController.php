<?php

namespace LunchTime\DeliveryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        /** @var $em \Doctrine\ORM\EntityManager */
        $em = $this->getDoctrine()->getEntityManager();


        $menus = $em->getRepository('LTDeliveryBundle:Menu')->getListWithItemsQuery()
            ->getResult();

        $orders = $em->getRepository('LTDeliveryBundle:Client\Order')->getListWithItemsQuery()
            ->getResult();

        return $this->render('LTDeliveryBundle:Default:index.html.twig', array(
            'menus' => $menus,
            'orders' => $orders,
        ));
    }

    /**
     * @Route("/company/{token}")
     * @Template()
     */
    public function companyAction($token)
    {
        /** @var $em \Doctrine\ORM\EntityManager */
        $em = $this->getDoctrine()->getEntityManager();

        $company = $em->getRepository('LTDeliveryBundle:Company')->findOneBy(array(
            'token' => $token,
        ));

        return $this->render('LTDeliveryBundle:Default:company.html.twig', array(
            'company' => $company,
        ));

    }

}
