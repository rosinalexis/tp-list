<?php

namespace App\Controller;

use App\Entity\Item;
use App\Repository\ItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ItemController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function home(ItemRepository $repo): Response
    {
        $items = $repo->findAll();

        return $this->render('item/home.html.twig', compact('items'));
    }

    /**
     * @Route("/items/add", name="app_item_add")
     */
    public function add(EntityManagerInterface $em, Request $request): Response
    {
        $title = $request->request->get('title'); 
        
        $item = new Item();
        $item->setTitle($title);
        $item->setIsCheck(false);
        $em->persist($item);
        $em->flush();

        return $this->redirectToRoute('app_home');
    }

     /**
     * @Route("/items/eddit/{id}", name="app_item_edit")
     */
    public function edit(Item $item,EntityManagerInterface $em): Response
    {
        if($item->getIsCheck() === true){
            $item->setIsCheck(false);
        }
        else{
            $item->setIsCheck(true);
        }
        
        $em->flush();
        
        return $this->redirectToRoute('app_home');
    }
    

     /**
     * @Route("/items/remove/{id}", name="app_item_remove")
     */
    public function remove(Item $item,EntityManagerInterface $em): Response
    {
        $em->remove($item);
        $em->flush();
        
        return $this->redirectToRoute('app_home');
    }
}
