<?php
namespace Jfa;

use Jfa\Model\Ingredient;
use Jfa\Model\IngredientTable;
use Jfa\Model\User;
use Jfa\Model\UserTable;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Jfa\Model\JunkFood;
use Jfa\Model\JunkFoodTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Authentication\Storage;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Jfa\Model\JunkFoodTable' =>  function($sm) {
                        $tableGateway = $sm->get('JunkFoodTableGateway');
                        $table = new JunkFoodTable($tableGateway);
                        return $table;
                    },
                'JunkFoodTableGateway' => function ($sm) {
                        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                        $resultSetPrototype = new ResultSet();
                        $resultSetPrototype->setArrayObjectPrototype(new JunkFood());
                        return new TableGateway('junkfood', $dbAdapter, null, $resultSetPrototype);
                    },
                'Jfa\Model\UserTable' =>  function($sm) {
                        $tableGateway = $sm->get('UserTableGateway');
                        $table = new UserTable($tableGateway);
                        return $table;
                    },
                'UserTableGateway' => function ($sm) {
                        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                        $resultSetPrototype = new ResultSet();
                        $resultSetPrototype->setArrayObjectPrototype(new User());
                        return new TableGateway('user', $dbAdapter, null, $resultSetPrototype);
                    },
                'Jfa\Model\IngredientTable' =>  function($sm) {
                        $tableGateway = $sm->get('UserTableGateway');
                        $table = new IngredientTable($tableGateway);
                        return $table;
                    },
                'IngredientTableGateway' => function ($sm) {
                        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                        $resultSetPrototype = new ResultSet();
                        $resultSetPrototype->setArrayObjectPrototype(new Ingredient());
                        return new TableGateway('ingriedient', $dbAdapter, null, $resultSetPrototype);
                    },
                'Jfa\Model\AuthStorage' => function($sm){
                        return new \Jfa\Model\AuthStorage('junk_users');
                    },
                'AuthService' => function($sm) {
                        $dbAdapter           = $sm->get('Zend\Db\Adapter\Adapter');
                        $dbTableAuthAdapter  = new DbTableAuthAdapter($dbAdapter,
                            'user','name','password', '');

                        $authService = new AuthenticationService();
                        $authService->setAdapter($dbTableAuthAdapter);
                        $authService->setStorage($sm->get('Jfa\Model\AuthStorage'));

                        return $authService;
                    },
            ),
        );
    }
}