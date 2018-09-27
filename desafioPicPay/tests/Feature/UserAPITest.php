<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserAPITest extends TestCase
{

    public function testGetUsers()
    {
        $pageTested = 0;
        $serviceUrl = "/api/users";

        do {
            $responde = $this->get($serviceUrl, ['HTTP_Authorization' => 'Bearer ' . $this->getToken()]);
            $responde->assertStatus(200);
            $content = json_decode($responde->content());

            try {
                foreach ($content->data as $users) {
                    $users->id;
                    $users->nome;
                    $users->username;
                    $users->id_auto;
                    $users->email;
                    $users->created_at;
                }
            } catch (\Exception $e) {
                echo $e;
            }

            $serviceUrl = $content->next_page_url;
            $pageTested++;
        } while ($content->next_page_url && $pageTested <= 5);

    }

    public function testGetUserByName()
    {
        $pageTested = 0;
        $serviceUrl = "/api/users?search=evecimar";

        do {
            $responde = $this->get($serviceUrl, ['HTTP_Authorization' => 'Bearer ' . $this->getToken()]);
            $responde->assertStatus(200);
            $content = json_decode($responde->content());

            try {
                foreach ($content->data as $users) {

                    $users->id;
                    $users->nome;
                    $users->username;
                    $users->id_auto;
                    $users->email;
                    $users->created_at;
                }
            } catch (\Exception $e) {
                echo $e;
            }

            $serviceUrl = $content->next_page_url;
            $pageTested++;
        } while ($content->next_page_url && $pageTested < 5);

    }

}
