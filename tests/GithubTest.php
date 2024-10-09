<?php

namespace App\Tests;

use App\Entity\User;
use App\Entity\GithubUserProvider;
use PHPUnit\Framework\TestCase;

class GithubTest extends TestCase
{
    private $client;
    private $serializer;
    private $response;
    private $stream;

    public function setUp():void {
      $this->client = $this->getMockBuilder('GuzzleHttp\Client')->disableOriginalConstructor()->getMock() ; 
      $this->serializer = $this->getMockBuilder('JMS\Serializer\Serializer')->disableOriginalConstructor()->getMock();
      $this->response = $this->getMockBuilder('Psr\Http\Message\ResponseInterface')->disableOriginalConstructor()->getMock();
      $this->stream = $this->getMockBuilder('Psr\Http\Message\StreamInterface')->disableOriginalConstructor()->getMock();
    }

    public function testSomethingGood(): void
    {
        $tab = [
            'email' => "kandji.k66@gmail.com",
            'password' => 'test'
        ];
       $this->client->method('get')->willReturn($this->response);
       $this->response->method('getBody')->willReturn($this->stream);
       $this->stream->method('getContents')->willReturn('foo');
       $this->serializer->expects($this->once())->method('deserialize')->willReturn($tab);
       $user = new User();
       $user->setEmail('kandji.k66@gmail.com');
       $user->setPassword('test');
     
       $githubUser = new GithubUserProvider($this->client,$this->serializer);
       $userGithub = $githubUser->loadUserByUsername('kandji');
       $this->assertSame($userGithub->getEmail(),$user->getEmail());
       $this->assertSame('App\Entity\User',get_class($userGithub));
    }

    public function testSomethingError(): void
    {
        $tab = [

        ];
       $this->client->method('get')->willReturn($this->response);
       $this->response->method('getBody')->willReturn($this->stream);
       $this->stream->method('getContents')->willReturn('foo');
       $this->serializer->expects($this->once())->method('deserialize')->willReturn($tab);
       $user = new User();
       $user->setEmail('kandji.k66@gmail.com');
       $user->setPassword('test');
     
       $githubUser = new GithubUserProvider($this->client,$this->serializer);
       $this->expectException('LogicException');
       $userGithub = $githubUser->loadUserByUsername('kandji');
    }
}
