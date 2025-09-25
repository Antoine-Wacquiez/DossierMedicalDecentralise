<?php

namespace App\Service;

use App\Repository\UserRepository;
use App\Entity\User;

class AdminProvider
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function get(): ?User
    {
        return $this->userRepository->createQueryBuilder('u')
            ->andWhere('u.roles LIKE :role')
            ->setParameter('role', '%"ROLE_ADMIN"%')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
