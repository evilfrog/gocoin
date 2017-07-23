<?php

namespace spec\EF\GoCoin\API;

use EF\GoCoin\API\Client;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

class ClientSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Client::class);
    }

    function let(Guzzle $guzzle)
    {
        //Mock some API responses
        $guzzle->request('GET', 'user')->willReturn(new Response(200, [], json_encode([
            'id'                      => '12312312-a8a8-41b8-b59d-8aa28d8f888d',
            'merchant_id'             => '79d5e489-6a5f-a2c7-b377-123123123123',
            'email'                   => 'john.doe@example.com',
            'first_name'              => 'John',
            'last_name'               => 'Doe',
            'created_at'              => '2017-01-07T04:54:47.934Z',
            'updated_at'              => '2017-05-17T18:22:56.494Z',
            'confirmed'               => true,
            'authy_id'                => NULL,
            'authy_enabled'           => false,
            'last_sign_in_with_authy' => NULL,
            'roles'                   => [
                0 => 'owner',
            ],
        ], true)));

        $this->beConstructedWith(
            'https://api.gocoin.com/api/v1/',
            'SUPER_SECRET_API_TOKEN',
            $guzzle
        );
    }

    function it_always_sets_proper_headers()
    {
        $this->beConstructedWith('https://someapi.com/v1/', 'SUPER_SECRET');
        $config = $this->getGuzzle()->getConfig();
        $config['base_uri']->__toString()->shouldReturn('https://someapi.com/v1/');
        $config['headers']['Authorization']->shouldReturn('Bearer SUPER_SECRET');
        $config['headers']['Content-Type']->shouldReturn('application/json');
    }

    function it_can_get_user_info()
    {
        $this->getUser()->shouldReturn([
            'id'                      => '12312312-a8a8-41b8-b59d-8aa28d8f888d',
            'merchant_id'             => '79d5e489-6a5f-a2c7-b377-123123123123',
            'email'                   => 'john.doe@example.com',
            'first_name'              => 'John',
            'last_name'               => 'Doe',
            'created_at'              => '2017-01-07T04:54:47.934Z',
            'updated_at'              => '2017-05-17T18:22:56.494Z',
            'confirmed'               => true,
            'authy_id'                => NULL,
            'authy_enabled'           => false,
            'last_sign_in_with_authy' => NULL,
            'roles'                   => [
                0 => 'owner',
            ],
        ]);
    }
}
