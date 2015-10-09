<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class SecurityController
{
    /**
     * @Route(
     *     "/{_locale}/login",
     *     name="login",
     *     requirements={ "_locale" = "fr|en" }
     * )
     * @Template
     */
    public function loginAction()
    {
        return array();
    }
}
