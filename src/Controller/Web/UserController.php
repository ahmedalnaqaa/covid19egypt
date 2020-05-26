<?php

namespace App\Controller\Web;

use App\Entity\Chat;
use App\Entity\Isolation;
use App\Entity\Message;
use App\Entity\User;
use App\Form\DoctorFeedbackType;
use App\Form\IsolationType;
use App\Form\MessageType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/user/confirm-case", name="user-confirm-case")
     * @Template()
     *
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function confirmCase(Request $request)
    {
        if (!$this->getUser()) {
            throw new NotFoundHttpException("");
        }
        $form = $this->createFormBuilder()
            ->add('symptomsStartSince', ChoiceType::class, [
                'required' => true,
                'choices' => [
                    'يوم' => 1,
                    'يومين' => 2,
                    '3 أيام' => 3,
                    '4 أيام' => 4,
                    '5 أيام' => 5,
                    '6 أيام' => 6,
                    '7 أيام' => 7,
                    '8 أيام' => 8,
                    '9 أيام' => 9,
                    '10 أيام' => 10,
                    '11 يوم' => 11,
                    '12 يوم' => 12,
                    '13 يوم' => 13,
                    '14 يوم' => 14,
                ],
                'label' => 'بداية ظهور الأعراض',
                'label_attr' => ['class' => 'col-sm-12']
            ])
            ->getForm();
        $form->handleRequest($request);
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        if ($form->isSubmitted()) {
            /** @var User $user */
            $user = $this->getUser();
            $days = $request->request->get('form')['symptomsStartSince'];
            $startDate = date('Y-m-d',(strtotime ( "-{$days} day" , strtotime ( date('Y-m-d')) )));
            $ymd = new \DateTime($startDate);
            $user->setSymptomsStartedAt($ymd);
            $em->persist($user);
            $em->flush();
            return  $this->redirect($this->generateUrl('index', [], UrlGeneratorInterface::ABSOLUTE_URL), 302);
        }

        return [
            'form' => $form->createView()
        ];
    }

    /**
     * @Route("/user/isolations", name="user-isolations", methods={"GET"})
     * @Template()
     *
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function userIsolations (Request $request)
    {
        if (!$this->getUser() || in_array('ROLE_DOCTOR', $this->getUser()->getRoles())) {
            return  $this->redirect($this->generateUrl('index', [], UrlGeneratorInterface::ABSOLUTE_URL), 302);
        }
        /** @var User $user */
        $user = $this->getUser();
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        /** @var Chat $chat */
        $chat = $em->getRepository('App:Chat')->findOneBy([
            'patient' => $user,
            'doctor' => $user->getAssignedDoctor(),
        ]);
        $message = new Message();
        $message->setChat($chat);
        $form = $this->createMessageForm($message);

        return [
            'isolations' => $user->getIsolations(),
            'messages' => $chat->getMessages(),
            'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/user/chat/{id}/message", name="create-message", methods={"POST"})
     * @Template()
     *
     * @param Chat $chat
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function postChatMessage(Chat $chat, Request $request)
    {
        $message = new Message();
        $message->setChat($chat);
        $form = $this->createMessageForm($message);

        $form->handleRequest($request);
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        if ($form->isSubmitted() && $request->getMethod() == 'POST') {
            $message->setSender($this->getUser());
            $em->persist($message);
            $em->flush();
        }
        $url = $request->headers->get('referer');
        return  $this->redirect(strtok($url, '?').'?'.http_build_query(['tab' => 'message']), 302);
    }

    /**
     * @Route("/user/isolation-form/{$date}", name="isolation-form", methods={"GET"})
     * @Template()
     *
     * @param string $date
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function isolationForm($date, Request $request)
    {
        if(!strtotime($date)){
            throw new BadRequestHttpException("Bad date format");
        }
        $isolation = new Isolation();
        $isolation->setCreatedAt(new \DateTime($date));
        $form = $this->createIsolationForm($isolation);
        return [
            'form' => $form->createView()
        ];
    }

    /**
     * @Route("/user/isolation-form", name="create-isolation", methods={"POST"})
     * @Template()
     *
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function createIsolation (Request $request)
    {
        $formCreatedAt = ($request->request->all()['isolation']['createdAt'])['date'];
        $isolationDate = new \DateTime("".$formCreatedAt['year']."-".$formCreatedAt['month']."-".$formCreatedAt['day']);
        $isolation = new Isolation();
        $isolation->setCreatedAt($isolationDate);
        $form = $this->createIsolationForm($isolation);

        $form->handleRequest($request);
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        if ($form->isSubmitted() && $request->getMethod() == 'POST') {
            $isolation->setUser($this->getUser());
            $em->persist($isolation);
            $em->flush();
            return  $this->redirect($this->generateUrl('user-isolations', [], UrlGeneratorInterface::ABSOLUTE_URL), 302);
        }

        return [
            'form' => $form->createView()
        ];
    }

    /**
     * @Route("/user/doctor-feedback-form/{id}", name="isolation-case-feedback")
     * @Template()
     *
     * @param Isolation $isolation
     * @param Request $request
     * @return mixed
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function createDoctorFeedback (Isolation $isolation, Request $request)
    {
        $form = $this->createDoctorFeedbackForm($isolation);

        $form->handleRequest($request);
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        if ($form->isSubmitted() && $request->getMethod() == 'POST') {
            $em->persist($isolation);
            $em->flush();
            return  $this->redirect($this->generateUrl('user-case-profile', ['id' => $isolation->getUser()->getId()], UrlGeneratorInterface::ABSOLUTE_URL), 302);
        }

        return [
            'form' => $form->createView()
        ];
    }

    /**
     * @Route("/doctor/isolations", name="doctor-isolations", methods={"GET"})
     * @Template()
     *
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function doctorCases ()
    {
        if (!$this->getUser() || !in_array('ROLE_DOCTOR', $this->getUser()->getRoles())) {
            return  $this->redirect($this->generateUrl('index', [], UrlGeneratorInterface::ABSOLUTE_URL), 302);
        }
        /** @var User $doctor */
        $doctor = $this->getUser();

        return [
            'users' => $doctor->getChildren()
        ];
    }

    /**
     * @Route("/user/{id}", name="user-case-profile", methods={"GET"})
     * @Template()
     *
     * @param User $user
     * @param Request $request
     * @return mixed
     */
    public function isolatedUserProfile (User $user, Request $request)
    {
        if (!$this->getUser() || $this->getUser() != $user->getAssignedDoctor()) {
            return  $this->redirect($this->generateUrl('index', [], UrlGeneratorInterface::ABSOLUTE_URL), 302);
        }
        $em = $this->getDoctrine()->getManager();
        /** @var Chat $chat */
        $chat = $em->getRepository('App:Chat')->findOneBy([
            'patient' => $user,
            'doctor' => $user->getAssignedDoctor(),
        ]);
        $message = new Message();
        $message->setChat($chat);
        $form = $this->createMessageForm($message);

        return [
            'user' => $user,
            'isolations' => $user->getIsolations(),
            'form' => $form->createView(),
            'messages' => $chat->getMessages(),
        ];
    }

    /**
     * @param Isolation $isolation
     * @return FormInterface
     */
    private function createIsolationForm (Isolation $isolation)
    {
        return $this->createForm(IsolationType::class, $isolation, [
            'action' => $this->generateUrl('create-isolation')
        ]);

    }

    /**
     * @param Isolation $isolation
     * @return FormInterface
     */
    private function createDoctorFeedbackForm (Isolation $isolation)
    {
        return $this->createForm(DoctorFeedbackType::class, $isolation, [
            'action' => $this->generateUrl('isolation-case-feedback', ['id'=> $isolation->getId()])
        ]);
    }

    /**
     * @param Message $message
     * @return FormInterface
     */
    private function createMessageForm (Message $message)
    {
        return $this->createForm(MessageType::class, $message, [
            'action' => $this->generateUrl('create-message', ['id'=> $message->getChat()->getId()]),
            'method' => 'POST'
        ]);
    }
}
