<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2019/06/26
 * Time: 17:42
 */

namespace App\Controller;

use App\Entity\MicroPost;
use App\Form\MicroPostType;
use App\Repository\MicroPostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

/**
 * @Route("/micro-post")
 */
class MicroPostController extends AbstractController
{

    /**
     * @var MicroPostRepository
     */
    private $microPostRepository;
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var RouterInterface
     */
    private $router;
    /**
     * @var FlashBagInterface
     */
    private $flashBag;

    public function __construct(MicroPostRepository $microPostRepository,
                                FormFactoryInterface $formFactory,
                                EntityManagerInterface $em,
                                RouterInterface $router,
                                FlashBagInterface $flashBag
                                 )
    {
        $this->microPostRepository = $microPostRepository;
        $this->formFactory = $formFactory;
        $this->em = $em;
        $this->router = $router;
        $this->flashBag = $flashBag;
    }

    /**
     * @Route("/", name="micro_post_index")
     */
    public function index(){
        return $this->render('micro-post/index.html.twig',
            ['posts' => $this->microPostRepository->findBy([],['time' => 'DESC'])]);
    }

    /**
     * @Route("/edit/{id}", name="micro_post_edit")
     */
    public function edit(MicroPost $microPost, Request $request){
        $form = $this->formFactory->create(
            MicroPostType::class,
            $microPost
        );

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($microPost);
            $this->em->flush();

            return new RedirectResponse($this->router->generate('micro_post_index'));
        }
        return $this->render('micro-post/add.html.twig',
            [ 'form'=> $form->createView()
            ]);
    }

    /**
     * @Route("/delete/{id}", name="micro_post_delete")
     */
    public function delete(MicroPost $microPost){
        $this->em->remove($microPost);
        $this->em->flush();

        $this->flashBag->add('notice', 'Micro post was deleted');

        return new RedirectResponse($this->router->generate('micro_post_index'));
    }

    /**
     * @Route("/add", name="micro_post_add")
     */
    public function add(Request $request){
        $microPost = new MicroPost();
        $microPost->setTime(new \DateTime());

        $form = $this->formFactory->create(
            MicroPostType::class,
            $microPost
        );

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($microPost);
            $this->em->flush();

            return new RedirectResponse($this->router->generate('micro_post_index'));
        }
        return $this->render('micro-post/add.html.twig',
            [ 'form'=> $form->createView()
            ]);
    }

    /**
     * @Route("/{id}", name="micro_post_post")
     */
    public function post(MicroPost $post){

        return $this->render('micro-post/post.html.twig',
            ['post' => $post]);
    }


}
