<?php


namespace App\Controller\Web;

use App\Constants\QuestionsMap;
use App\Entity\Test;
use App\Form\QuestionType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{
    /**
     * @param Request $request
     * @return array
     * @throws ORMException
     * @throws OptimisticLockException
     * @Route("/corona-test", name="corona-test")
     * @Template()
     *
     */
    public function testAction (Request $request)
    {
        $form = $this->createForm(QuestionType::class, null);

        $form->handleRequest($request);
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        if ($form->isSubmitted() && $form->isValid()) {
            $score = 0;
            foreach ($request->request->all() as $key => $value) {
                if (array_key_exists($key, QuestionsMap::getQuestionsScores()) && $value) {
                    $score += QuestionsMap::getQuestionsScores()[$key];
                }
            }
            $test = new Test();
            if ($this->getUser()) {
                $test->setUser($this->getUser());
            }
            $test->setData($request->request->all());
            $test->setScore($score);
            $em->persist($test);
            $em->flush();
            $response = new Response();
            if (empty($response->headers->getCookies())) {
                $this->createCookie();
            }
            return [
                'test' => $test
            ];
        }

        return [
            'form' => $form->createView()
        ];
    }

    private function createCookie()
    {
        $cookieGuest = array(
            'name'  => 'didthetest',
            'value' => '1',
            'path'  => $this->generateUrl('corona-test'),
            'time'  => time() + 3600 * 24 * 7
        );

        $cookie = new Cookie($cookieGuest['name'], $cookieGuest['value'], $cookieGuest['time'], $cookieGuest['path']);

        $response = new Response();
        $response->headers->setCookie($cookie);
        $response->send();
    }
}
