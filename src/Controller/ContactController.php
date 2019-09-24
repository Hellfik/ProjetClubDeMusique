<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function contact()
    {
        $form = $this->createFormBuilder()
        ->add('email', EmailType::class)
        ->add('message', TextareaType::class)
        ->getForm();
            
        
        return $this->render('contact.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
