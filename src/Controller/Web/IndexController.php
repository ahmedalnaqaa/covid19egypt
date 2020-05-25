<?php

namespace App\Controller\Web;

use App\Entity\Location;
use App\Entity\Test;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
        $cases = $em->createQuery($dql)->getArrayResult();
        $lastCase = $em->getRepository('App:Cases')->findBy([], ['createdAt' => 'DESC'], 1);

        $viewScores = false;
        if ($viewScores) {
            $parentLocations = $em->getRepository('App:Location')->findBy(['parent'=>null]);
            $testsQB = $em->getRepository('App:Test')->createQueryBuilder('test');
            $testsQB->andWhere($testsQB->expr()->between('test.createdAt', ':start_date', ':end_date'))
                ->setParameter(':start_date', date("Y-m-d 00:00:00", strtotime('-3 weeks')))
                ->setParameter(':end_date', date("Y-m-d 00:00:00"))
            ;
            $tests = $testsQB->getQuery()->getResult();
            $locationsScores = [];
            $totalScore = 0;
            /** @var Location $parentLocation */
            foreach ($parentLocations as  $parentLocation) {
                $score = 0;
                /** @var Test $test */
                foreach ($tests as $test) {
                    if ($test->getLocation() == $parentLocation
                        || ($test->getLocation()->getParent()
                            && $test->getLocation()->getParent() == $parentLocation)) {
                        $score += $test->getScore();
                    }
                }
                $locationsScores[] = ['location' => $parentLocation, 'score' => $score];
                $totalScore += $score;
            }
            usort($locationsScores, function ($item1, $item2) {
                return $item2['score'] <=> $item1['score'];
            });
            return [
                'lastCase' => reset($lastCase),
                'cases' => $cases,
                'viewScores' => $viewScores,
                'scores' => $locationsScores,
                'totalScore' => $totalScore,
            ];
        } else {
            return [
                'lastCase' => reset($lastCase),
                'cases' => $cases,
                'viewScores' => $viewScores,
            ];
        }
    }

    /**
     * @Route("/cases", name="cases")
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
     * @Route("/cases/{date}", name="show_case", methods={"GET"})
     * @Template()
     * @param string $date
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    public function showCase ($date ,Request $request)
    {
        if(!strtotime($date)){
            throw new BadRequestHttpException("Bad date format");
        }
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $case = $em->getRepository('App:Cases')->findOneBy([
            'createdAt' => new \DateTime($date)
        ]);
        if (!$case) {
            throw new NotFoundHttpException("Date not found");
        }
        $lastCase = $em->getRepository('App:Cases')->findBy([], ['createdAt' => 'DESC'], 1);
        $dql   = "SELECT c FROM App\Entity\Cases c WHERE  c.createdAt <= ?1 ORDER BY c.createdAt DESC";
        $cases = $em->createQuery($dql)->setParameter(1, new \DateTime($date))->getArrayResult();

        return [
            'case' => $case,
            'cases' => $cases,
            'lastCase' => reset($lastCase),
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

    /**
     * @Route("/isolate-yourself", name="isolate-yourself", methods={"GET"})
     * @Template()
     *
     * @param Request $request
     * @return array
     */
    public function isolationInfo(Request $request)
    {
        return [];
    }

    /**
     * @Route("/isolation-protocol", name="isolation-protocol", methods={"GET"})
     * @Template()
     *
     * @param Request $request
     * @return array
     */
    public function isolationProtocol(Request $request)
    {
        return [];
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
