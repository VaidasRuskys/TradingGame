<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return new Response(
            '<html><body>Homepage</body></html>'
        );
    }
}
