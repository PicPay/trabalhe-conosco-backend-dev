<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function getToken()
    {
        $data = (array)json_decode('{
            "grant_type":"password",
            "client_id": "1",
            "client_secret" : "bnXSI5SigoHCx9dVHUT3nrTUfdVk9Sbvecda82bz",
            "username" : "evecimar.silva",
            "password" : "qwe123",
            "scope" : "*"
        }');
        $headers = ["Accept" => "application/json"];
        $reponse = $this->post("/oauth/token", $data, ["Accept" => "application/json"]);

        $reponse->assertStatus(200);
        $content = json_decode($reponse->content());

        return $content->access_token;

    }

}
