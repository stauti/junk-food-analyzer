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
        $request = new Request();
        $request->getHeaders()->addHeaders(array(
            'Content-Type' => 'application/json; charset=UTF-8'
        ));
        $request->setUri("http://junk.local/index.php/junkfood");
        $request->setMethod('GET');

        $client = new Client();
        $response = $client->dispatch($request);

        $junk = json_decode($response->getContent(), true);

        return new ViewModel(array('junk' => $junk['data']));
    }

    public function detailAction()
    {
        $id = (int) $this->params('id');
        $junk = array();

        if ($id) {
            $request = new Request();
            $request->getHeaders()->addHeaders(array(
                'Content-Type' => 'application/json; charset=UTF-8'
            ));
            $request->setUri("http://junk.local/index.php/junkfood/" . $id);
            $request->setMethod('GET');

            $client = new Client();
            $response = $client->dispatch($request);

            $junk = json_decode($response->getContent(), true);
            $junk = $junk[0];
        }

        return new ViewModel(array('junk' => $junk));
    }

    public function editAction()
    {
        $junk = array();
        $id = (int) $this->params('id');

        if ($id) {
            $request = new Request();
            $request->getHeaders()->addHeaders(array(
                'Content-Type' => 'application/json; charset=UTF-8'
            ));
            $request->setUri("http://junk.local/index.php/junkfood/" . $id);
            $request->setMethod('GET');

            $client = new Client();
            $response = $client->dispatch($request);

            $junk = json_decode($response->getContent(), true);
            $junk = $junk[0];
        }

        $request = new Request();
        $request->getHeaders()->addHeaders(array(
            'Content-Type' => 'application/json; charset=UTF-8'
        ));
        $request->setUri("http://junk.local/index.php/ingredient");
        $request->setMethod('GET');

        $client = new Client();
        $response = $client->dispatch($request);

        $ingredients = json_decode($response->getContent(), true);
        $ingredients = $ingredients['data'];

        return new ViewModel(array('junk' => $junk, 'ingredients' => $ingredients, 'id' => $id));
    }

    public function saveAction()
    {
        $post = $this->getRequest()->getPost();
        $id = false;

        if (isset($post['junkfoodID']) && $post['junkfoodID']) {
            $id = $post['junkfoodID'];
            unset($post['junkfoodID']);
        }

        $request = new Request();
        $request->getHeaders()->addHeaders(array(
            'Content-Type' => 'application/json; charset=UTF-8'
        ));

        if ($id) {
            $request->setUri("http://junk.local/index.php/junkfood/" . $id);
            $request->setMethod('PUT');
        } else {
            $request->setUri("http://junk.local/index.php/junkfood");
            $request->setMethod('Post');
        }

        $request->setContent(json_encode($post));

        $client = new Client();
        $response = $client->dispatch($request);

        var_dump($response->getContent());

        return $this->redirect('home');
    }

    public function loginAction()
    {
        return new ViewModel();
    }

    public function authAction()
    {
        $post = $this->getRequest()->getPost();
        $request = new Request();
        $request->getHeaders()->addHeaders(array(
            'Content-Type' => 'application/json; charset=UTF-8'
        ));
        $request->setUri("http://junk.local/index.php/user");
        $request->setMethod('POST');
        $request->setContent(json_encode($post));

        $client = new Client();
        $response = $client->dispatch($request);

        $message = json_decode($response->getContent(), true);

        var_dump($message);

        return new ViewModel();
    }
}
