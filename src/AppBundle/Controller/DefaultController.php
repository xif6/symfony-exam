<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Food;
use AppBundle\Entity\NutrientFood;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return [];
    }

    /**
     * @Route("/food/{id}", name="food")
     * @ParamConverter("food", class="AppBundle:Food")
     * @Template()
     */
    public function foodAction(Request $request, Food $food)
    {
        return ['food' => $food];
    }

}
