<?php

namespace ML\EventApiBundle\Controller;

use ML\HydraBundle\Controller\HydraController;
use ML\HydraBundle\Mapping as Hydra;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ML\EventApiBundle\Entity\EntryPoint;

/**
 * EntryPoint controller
 *
 * @Route("/")
 */
class EntryPointController extends HydraController
{
    /**
     * The APIs main entry point.
     *
     * @Route("/", name="entry_point")
     * @Method("GET")
     *
     * @Hydra\Operation()
     *
     * @return ML\EventApiBundle\Entity\EntryPoint
     */
    public function getAction()
    {
        return new EntryPoint();
    }
}
