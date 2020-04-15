<?php


namespace App\Controller\Web;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/my-tests", name="user-tests")
     * @Template()
     *
     * @param Request $request
     * @return array
     */
    public function myTests (Request $request)
    {
        if (!$this->getUser()) {
            throw new NotFoundHttpException("");
        }

        return [
            'userTests' => $this->getUser()->getTests()
        ];
    }
}
