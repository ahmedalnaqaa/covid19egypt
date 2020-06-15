<?php

namespace App\Controller\Web;

use App\Entity\Cases;
use App\Entity\Chat;
use App\Entity\Location;
use App\Entity\Test;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


class IndexController extends AbstractController
{

    /**
     * @var PaginatorInterface
     */
    private $paginator;

    public function __construct(PaginatorInterface $paginator)
    {
        $this->paginator = $paginator;
    }

    /**
     * @Route("/", name="index")
     * @Template()
     *
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    public function index(Request $request)
    {
        $dql   = "SELECT c FROM App\Entity\Cases c ORDER BY c.createdAt DESC";
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $cases = $em->createQuery($dql)->getArrayResult();
        /** @var Cases $lastCase */
        $lastCase = $em->getRepository('App:Cases')->findOneBy([], ['createdAt' => 'DESC']);
        $statistics = $this->generateStatistics(array_slice($cases,0, 14));
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
                'lastCase' => $lastCase,
                'cases' => $cases,
                'viewScores' => $viewScores,
                'scores' => $locationsScores,
                'totalScore' => $totalScore,
                'statistics' => $statistics,
            ];
        } else {
            return [
                'lastCase' => $lastCase,
                'cases' => $cases,
                'viewScores' => $viewScores,
                'statistics' => $statistics,
            ];
        }
    }

    /**
     * @Route("/cases", name="cases")
     * @Template()
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    public function egyptCases (Request $request)
    {
        $dql   = "SELECT c FROM App\Entity\Cases c ORDER BY c.createdAt DESC";
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery($dql);
        $pagination = $this->paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            14
        );
        /** @var Cases $lastCase */
        $lastCase = $em->getRepository('App:Cases')->findOneBy([], ['createdAt' => 'DESC']);
        return [
            'lastCase' => $lastCase,
            'cases' => $pagination,
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
        /** @var Cases $lastCase */
        $lastCase = $em->getRepository('App:Cases')->findOneBy([], ['createdAt' => 'DESC']);
        $dql   = "SELECT c FROM App\Entity\Cases c WHERE  c.createdAt <= ?1 ORDER BY c.createdAt DESC";
        $cases = $em->createQuery($dql)->setParameter(1, new \DateTime($date))->getArrayResult();
        $statistics = [];
        if ($lastCase == $case) {
            $statistics = $this->generateStatistics($cases);
        }
        return [
            'case' => $case,
            'cases' => $cases,
            'lastCase' => $lastCase,
            'statistics' => $statistics,
        ];
    }

    /**
     * @Route("/ask-doctor", name="ask-doctor", methods={"GET"})
     * @Template()
     * @param string $date
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Exception
     */
    public function askDoctor (Request $request)
    {
        if (!$this->getUser()) {
            return  $this->redirect($this->generateUrl('fos_user_registration_register',
                ['tid'=> $request->query->get('tid'), 'type'=> $request->query->get('type')],
                UrlGeneratorInterface::ABSOLUTE_URL), 302);
        }
        /** @var User $user */
        $user = $this->getUser();
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $chat = $em->getRepository('App:Chat')->findOneBy(['patient' => $user]);
        if (!$chat) {
            $chat = new Chat();
            $chat->setPatient($user);
            if ($user->getAssignedDoctor()) {
                $chat->setDoctor($user->getAssignedDoctor());
            } else {
                $qb = $em->createQueryBuilder();
                $qb->select('u')
                    ->from('App:User', 'u')
                    ->where($qb->expr()->like('u.roles', ':roles'))
                    ->setParameter('roles', '%"ROLE_DOCTOR"%');

                $doctors = $qb->getQuery()->getResult();
                $chat->setDoctor($doctors[array_rand($doctors)]);
               ;
            }
            $em->persist($chat);
            $em->flush();
        }
        return  $this->redirect($this->generateUrl('user', [], UrlGeneratorInterface::ABSOLUTE_URL), 302);
    }

    /**
     * @Route("/start-isolation", name="start-isolation", methods={"GET"})
     * @Template()
     * @param string $date
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Exception
     */
    public function startIsolation(Request $request)
    {
        if (!$this->getUser()) {
            return  $this->redirect($this->generateUrl('fos_user_registration_register',
                ['tid'=> $request->query->get('tid'), 'type'=> $request->query->get('type')],
                UrlGeneratorInterface::ABSOLUTE_URL), 302);
        }
        /** @var User $user */
        $user = $this->getUser();
        if (!$user->getAssignedDoctor()) {
            /** @var EntityManager $em */
            $em = $this->getDoctrine()->getManager();
            $chat = $em->getRepository('App:Chat')->findOneBy(['patient' => $user]);
            if ($chat) {
                $user->setAssignedDoctor($chat->getDoctor());
                $user->setIsolationStartedAt(new \DateTime());
                $user->setIsolationEndAt(new \DateTime('+14 day'));
                $em->persist($user);
                $em->flush();
            }
            if ($request->query->get('tid')) {
                /** @var Test $test */
                $test = $em->getReference('App:Test', $request->query->get('tid'));
                $test->setUser($user);
                $em->persist($test);
                $em->flush();
            }
        }
        return  $this->redirect($this->generateUrl('user', [], UrlGeneratorInterface::ABSOLUTE_URL), 302);
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

    private function getRequest($url)
    {
        $cURLConnection = curl_init();

        curl_setopt($cURLConnection, CURLOPT_URL, $url);
        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

        $statusList = curl_exec($cURLConnection);
        curl_close($cURLConnection);

        return json_decode($statusList, true)['result'];
    }

    /**
     * @param array $cases
     * @return mixed
     */
    private function generateStatistics ($cases = [])
    {
        $casesRanges = [];
        $recoveredRanges = [];
        $deathsRanges = [];
        /**
         * @var  $key
         * @var Cases $case
         */
        foreach (array_slice($cases,0,7) as $key => $case){
            /** @var Cases $caseToCompareWith */
            $caseToCompareWith = $cases[$key+7];
            $casesRanges[] = round(($case['totalCases'] / $caseToCompareWith['totalCases']), 1);
            $recoveredRanges[] = round(($case['totalRecovered'] / $caseToCompareWith['totalRecovered']), 1);
            $deathsRanges[] = round(($case['totalDeaths'] / $caseToCompareWith['totalDeaths']), 1);
        }
        $casesRange = array_sum($casesRanges)/7;
        $recoveredRange = array_sum($recoveredRanges)/7;
        $deathsRange = array_sum($deathsRanges)/7;

        $statics['cases'] = (int) round($casesRange * $cases[0]['totalCases']);
        $statics['recovered']['total'] = (int) round($recoveredRange * $cases[0]['totalRecovered']);
        $statics['recovered']['percentage'] = round(($statics['recovered']['total']/$statics['cases']) * 100, 1);
        $statics['deaths']['total'] = (int) round($deathsRange * $cases[0]['totalDeaths']);
        $statics['deaths']['percentage'] = round(($statics['deaths']['total']/$statics['cases']) * 100, 1);

        return $statics;
    }
}
