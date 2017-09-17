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
     * @Route("/search", name="search")
     */
    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $q = $request->query->get('q');
        $foods = $this->getDoctrine()->getRepository('AppBundle:Food')->search($q);
        return new JsonResponse($foods);
    }

    /**
     * @Route("/food/{id}", name="food")
     * @ParamConverter("food", class="AppBundle:Food")
     */
    public function foodAction(Request $request, Food $food)
    {
        $out = [
            'name' => $food->getName(),
            'nutrient' => $this->nutrientFormat($food->getNutrientsFood())
        ];
        return new JsonResponse($out);
    }

    protected function nutrientFormat($nutrientsFood)
    {
        $out = [];
        foreach ($nutrientsFood as $nutrientFood) {
            $out[] = [
                'name' => $nutrientFood->getNutrient()->getName(),
                'value' => $nutrientFood->getValue(),
            ];
        }
        return $out;
    }
}
