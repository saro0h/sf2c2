<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class SecurityController
{
    /**
     * @Route("/login", name="login")
     * @Template
     */
    public function loginAction()
    {
        return array();
    }
}
