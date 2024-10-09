<?php
namespace App\Tests\Fonctionnel;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeTest extends WebTestCase {
    private $http;
    private $router;
    private $doctrine;
    private $hasher;
    public function Setup():void {
        $this->http = self::createClient();
        $this->router = $this->getContainer()->get('router.default');
        $this->doctrine = $this->getContainer()->get('doctrine.orm.entity_manager');
        
    }

    public function testGoHomeNoLogin() {
        $this->http->request(Request::METHOD_GET,$this->router->generate('app_home'));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testGoHomeWithLogin() {
        /*$user = new User();
        $user->setEmail('kandji.k66@gmail.com');
        $user->setPassword('test');
        $this->doctrine->persist($user);
        $this->doctrine->flush();*/
        $repoUser = $this->doctrine->getRepository(User::class);
        $newUserSave = $repoUser->findOneByEmail('kandji.k66@gmail.com');      
        $this->http->request(Request::METHOD_GET,$this->router->generate('app_home'));
        $this->loginUser($newUserSave);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

    }

    public function loginUser($user) {
        $crawler = $this->http->request(Request::METHOD_GET,$this->router->generate('app_login'));
        $form = $crawler->selectButton('Sign in')->form();
        $form['email'] = $user->getEmail();
        $form['password'] = 'test';
        $this->http->submit($form);
        $this->http->followRedirect();
        $this->assertSelectorTextContains('body','Welcome');
      
    }
}