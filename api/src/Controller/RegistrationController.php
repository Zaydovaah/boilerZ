<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", Methods="POST")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $data = $request->toArray();
        $user = new User();

        $password = $data['password'];
        $confirmPassword = $data['confirmPassword'];

        // show error if passwords dont match
        if ($password != $confirmPassword) {
            return new JsonResponse(sprintf('Les mots de passe doivent correspondre.'));
        }

            $user->setEmail($data['email']);
            $user->setPassword($passwordEncoder->encodePassword($user, $password));


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email

        return new JsonResponse(sprintf('Compte enregistré avec succés!'));
    }
}
