<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Http\Request;
use Zend\Http\Client;
use Zend\Stdlib\Parameters;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }

    public function listAction()
    {
        $request = new Request();
        $request->getHeaders()->addHeaders(array(
            'Content-Type' => 'application/json; charset=UTF-8'
        ));
        $request->setUri("http://junk.local/junkfood");
        $request->setMethod('GET');

        $client = new Client();
        $response = $client->dispatch($request);

        $junk = json_decode($response->getContent(), true);

        return new ViewModel(array('junk' => $junk));
    }

    public function jailAction()
    {
        return new ViewModel();
    }
}
