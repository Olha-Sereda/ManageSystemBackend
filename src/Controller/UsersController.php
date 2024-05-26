<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;


class UsersController extends AbstractController
{
    #[Route('/api/users', name: 'get_users', methods: 'GET')]
    public function getUsers(UserRepository $userRepository): JsonResponse
    {
        $users = $userRepository->findAll();

        $data = [];
        foreach ($users as $user) {
            $data[] = [
                'id' => $user->getId(),
                'user_name' => $user->getUserName(),
                'user_surname' => $user->getUserSurname(),
                'email' => $user->getEmail(),
                // 'password' => $user->getPassword(), // It's not a good practice to expose passwords
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/api/users', name: 'add_user', methods: 'POST')]
    public function addUser(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $user = new User();
        $user->setUserName($data['user_name']);
        $user->setUserSurname($data['user_surname']);
        $user->setEmail($data['email']);
        $user->setPassword($data['password']);
        $em->persist($user);
        $em->flush();
    
        return new JsonResponse(['id' => $user->getId()], Response::HTTP_CREATED);
    }

    #[Route('/api/users/{userId<\d+>}', name: 'remove_user', methods: 'DELETE')]
    public function removeUser(int $userId, UserRepository $userRepository, EntityManagerInterface $em): JsonResponse
    {
        $user = $userRepository->find($userId);
        if ($user) {
            $em->remove($user);
            $em->flush();
        }

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    #[Route('/api/users/{userId<\d+>}', name: 'edit_user', methods: 'PATCH')]
    public function editUser(int $userId, Request $request, UserRepository $userRepository, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $user = $userRepository->find($userId);
        if ($user) {
            $user->setUserName($data['user_name']);
            $user->setUserSurname($data['user_surname']);
            $user->setEmail($data['email']);
            $user->setPassword($data['password']);
            $em->flush();
        }

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
    
    
}
