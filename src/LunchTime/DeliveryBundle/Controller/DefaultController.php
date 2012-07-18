<?php

namespace LunchTime\DeliveryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;

use LunchTime\DeliveryBundle\Entity\Client;
use LunchTime\DeliveryBundle\Entity\Company;

class DefaultController extends Controller
{
    //TODO: move to company controller

    /** @var Company $company Current company */
    protected $company = null;

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
        $company = $this->getCompany($token);

        return $this->render('LTDeliveryBundle:Default:company.html.twig', array(
            'company' => $company,
        ));

    }

    /**
     * @Route(pattern="/client/{token}", name="clientPage")
     * @Template()
     */
    public function clientAction($token)
    {
        $client = $this->getClient($token);

        return $this->render('LTDeliveryBundle:Default:client.html.twig', array(
            'client' => $client,
        ));

    }

    /**
     * @Route(pattern="/company/{token}/signup", name="signup")
     */
    public function signup($token)
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getEntityManager();

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

    protected function mapClient($data)
    {
        $client = new Client();

        $client->setCompany($data['company']);
        $client->setName($data['name']);
        $client->setEmail($data['email']);
        $client->setToken(Company::generateToken(10));

        return $client;
    }

    protected function getCompany($token)
    {
        $em = $this->getEntityManager();

        $company = $em->getRepository('LTDeliveryBundle:Company')->findOneBy(array(
            'token' => $token,
        ));

        return $company;
    }

    protected function getClient($token)
    {
        $em = $this->getEntityManager();

        $client = $em->getRepository('LTDeliveryBundle:Client')->findOneBy(array(
            'token' => $token,
        ));

        return $client;
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getEntityManager()
    {
        return $this->getDoctrine()->getEntityManager();
    }

}
