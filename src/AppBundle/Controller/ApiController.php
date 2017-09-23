<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api/v1")
 */
class ApiController extends Controller
{
    /**
     * @Route("/foods/search.{_format}", name="api_search")
     */
    public function searchAction(SerializerInterface $serializer, Request $request, $_format)
    {
        $finder = $this->container->get('fos_elastica.finder.app.food');

        $q = $request->query->get('q');

        $results = $finder->find($q, 50);

        return new Response($serializer->serialize($results, $_format, array('groups' => array('food'))));
    }
}
