<?php

namespace AppBundle\Service;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Util\SecureRandom;
use AppBundle\Entity\User;

class AppCredentialsHandler
{
    private $encoder;

    private $saltGenerator;

    public function __construct(UserPasswordEncoder $encoder, SecureRandom $saltGenerator)
    {
        $this->encoder = $encoder;
        $this->saltGenerator = $saltGenerator;
    }

    public function manageCredentials(User $user)
    {
        $salt = $this->saltGenerator->nextBytes(15);
        $user->setSalt(md5($salt));

        $encodedPassword = $this->encoder->encodePassword($user, $user->getPassword());

        $user->setPassword($encodedPassword);

        return $user;
    }
}