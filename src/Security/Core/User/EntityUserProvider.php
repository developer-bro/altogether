<?php

namespace App\Security\Core\User;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\EntityUserProvider as BaseClass;

class EntityUserProvider extends BaseClass

{

    protected $class;

public function __construct(ManagerRegistry $registry, $class, array $properties, $managerName = null)
    {
        $this->em = $registry->getManager($managerName);
        $this->class = $class;
        $this->properties = array_merge($this->properties, $properties);
    }

    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $resourceOwnerName = $response->getResourceOwner()->getName();

        if (!isset($this->properties[$resourceOwnerName])) {
            throw new \RuntimeException(sprintf("No property defined for entity for resource owner '%s'.", $resourceOwnerName));
        }

        $data = $response->getData();
        var_dump(
            $response->getRealName()
        );

        $username = $response->getUsername();
        if (null === $user = $this->findUser(array($this->properties[$resourceOwnerName] => $username))) {
            throw new UsernameNotFoundException(sprintf("User '%s' not found.", $username));
        }

        return $user;
    }

}

