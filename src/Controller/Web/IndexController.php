<?php

namespace App\Controller\Web;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @Template()
     *
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        $dql   = "SELECT c FROM App\Entity\Cases c ORDER BY c.createdAt DESC";
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery($dql);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            45
        );
        $lastCase = $em->getRepository('App:Cases')->findBy([], ['createdAt' => 'DESC'], 1);

        return [
            'lastCase' => reset($lastCase),
            'cases' => $pagination
        ];
    }

    /**
     * @Route("/covid19-egypt-cases", name="cases")
     * @Template()
     * @param Request $request
     * @return array
     */
    public function egyptCases (Request $request)
    {
        $dql   = "SELECT c FROM App\Entity\Cases c ORDER BY c.createdAt DESC";
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery($dql);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            25
        );
        $lastCase = $em->getRepository('App:Cases')->findBy([], ['createdAt' => 'DESC'], 1);

        return [
            'lastCase' => reset($lastCase),
            'cases' => $pagination
        ];
    }

    /**
     *
     * @Route("/covid19-egypt-questions", name="questions")
     * @Template()
     */
    public function commonQuestions()
    {
        return [
        ];
    }

    /**
     *
     * @Route("/covid19-egypt-advices", name="advices")
     * @Template()
     */
    public function advices ()
    {
        return [
        ];
    }

    private function getRequest($url) {
        $cURLConnection = curl_init();

        curl_setopt($cURLConnection, CURLOPT_URL, $url);
        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

        $statusList = curl_exec($cURLConnection);
        curl_close($cURLConnection);

        return json_decode($statusList, true)['result'];
    }
}
