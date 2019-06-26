<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2019/06/25
 * Time: 22:32
 */

namespace App\Controller;

use App\Service\Greeting;
use App\Service\VeryBadDesign;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @var Greeting
     */
    private $greeting;

    /**
     * @var VeryBadDesign
     */
    private $badDesign;

    public function __construct(Greeting $greeting, VeryBadDesign $badDesign)
    {
        $this->greeting = $greeting;
        $this->badDesign = $badDesign;
    }

    /**
     * @Route("/{name}", name="blog_index")
     */
    public function index($name){
        return $this->render('base.html.twig', ['message' => $this->greeting->greet(
            $name
        )]);
    }
}
