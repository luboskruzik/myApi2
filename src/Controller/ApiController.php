<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;

class ApiController extends AbstractController
{

    public function saveUser(
        HttpFoundation\Request $request,
        ManagerRegistry $registry
    ): HttpFoundation\JsonResponse
    {   
        $json = $request->getContent();
        $content = json_decode($json);

        $user = new User();
        $user->setEmail($content->email);
        $user->setTitle($content->title);
        $user->setFirstName($content->first_name);
        $user->setLastName($content->last_name);
        $user->setPhone($content->phone);
        $user->setPrefix($content->prefix);
        $user->setCountry($content->country);
        $user->setNewsletter($content->newsletter);
        $date = new \DateTimeImmutable();
        $date->setTimestamp($content->created_at);
        $user->setCreatedAt($date);
        $user->setPassword($content->password);
        $entityManager = $registry->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

//	    return new HttpFoundation\Response(null, HttpFoundation\Response::HTTP_CREATED);
        return new HttpFoundation\JsonResponse(null, HttpFoundation\Response::HTTP_CREATED);
    }

    public function getUserByEmail(
        HttpFoundation\Request $request, 
        UserRepository $userRepository
        ): HttpFoundation\JsonResponse
    {
        $email = $request->query->get('email');
        $user = $userRepository->findOneBy(['email' => $email]);

        if (null === $user) {
            return $this->json(['user' => (bool) $user]);
        }
        
        return $this->json(['user' => [
            'id' => $user->getId(),
            'title' => $user->getTitle(),
            'first_name' => $user->getFirstName(),
            'last_name' => $user->getLastName(),
            'phone' => $user->getPrefix(),
            'prefix' => $user->getPrefix(),
            'country' => $user->getCountry(),
            'newsletter' => $user->isNewsletter(),
            'password' => $user->getPassword(),
            'email' => $user->getEmail()
        ]]);
        
    }

    public function getUserById(int $id)
    {
        dd('getUserById');
    }

}
