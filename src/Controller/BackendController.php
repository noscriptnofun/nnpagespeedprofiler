<?php
# @Author: andreasprietzel
# @Date:   1970-01-01T01:00:00+01:00
# @Last modified by:   andreasprietzel
# @Last modified time: 2020-08-10T12:31:57+02:00

namespace nsnf\NNPageSpeedProfiler\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use nsnf\NNPageSpeedProfiler\ContaoBackendController;

/**
 * Handles back end routes.
 *
 */
class BackendController extends Controller
{
    /**
     * Renders the details content.
     *
     * @return Response
     *
     */
    public function savennpagespeedprofilerresultAction()
    {
        $this->container->get('contao.framework')->initialize();
        $controller = new ContaoBackendController();
        return $controller->run();
    }
}
