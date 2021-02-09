<?php
namespace Tests;

use App\Http\Controllers\AutenticacaoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Tests\TestCase;
class AuthService
        {
            public function  auth()
            {
                return null;
            }
        }
class LoginRouteTest extends TestCase
{
    /**
     * Factory AutenticacaoController
     */
    public function autenticaoControllerStub()
    {
        return new AutenticacaoController(new AuthService());
    }
    /**
     * Retorna status 422 se a senha não estiver presente
     * @return void
     */

    public function testRetorna422SeASenhaNaoEstaPresente()
    {
        $requestParams = ['email'=>'any_mail@mail.com'];
        $autenticacao =$this->autenticaoControllerStub();
        $rota = Request::create('login', 'POST',$requestParams);
        $rota->headers->set('authorization', 'tova');
        $resp = $autenticacao->autenticar($rota);
        $this->assertEquals(422, $resp->getStatusCode());
        $this->assertEquals(
            "O paramentro senha não encontrado",
            json_decode($resp->getContent())->message
        );
    }

      /**
     * Retorna status 422 se a senha não estiver presente
     * @return void
     */

    public function testRetorna422SeOEmailNaoEstaPresente()
    {
        $requestParams = ['password'=>'any_password'];
        $autenticacao = $this->autenticaoControllerStub();
        $rota = Request::create('login', 'POST',$requestParams);
        $rota->headers->set('authorization', 'tova');
        $resp = $autenticacao->autenticar($rota);
        $this->assertEquals(422, $resp->getStatusCode());
        $this->assertEquals(
            "O paramentro email não encontrado",
            json_decode($resp->getContent())->message
        );
    }
    /**
     * Retorna 403 caso não tiver a chave authorization
     */
    public function testRetorn403CasoNaoTerChaveAuthorizationHeader()
    {
        $requestParams = ['password'=>'any_password'];
        $autenticacao = $this->autenticaoControllerStub();
        $rota = Request::create('login', 'POST',$requestParams);
        $resp = $autenticacao->autenticar($rota);

        $this->assertEquals(403, $resp->getStatusCode());
        $this->assertEquals(
            "A chave de autorização deve ser inforamda",
            json_decode($resp->getContent())->message
        );
    }

    /**
     * Retorna 422 caso o email seja invalido
     * @return void
     */

    public function testRetorna422CasoEmailSejaInvalido()
    {

        $requestParams = [
            'email'=>'email_invalid.com',
            'password' =>'any_password'
        ];
        $autenticacao = $this->autenticaoControllerStub();
        $rota = Request::create('login', 'POST',$requestParams);
        $rota->headers->set('authorization', 'tova');
        $resp = $autenticacao->autenticar($rota);
        $this->assertEquals(422, $resp->getStatusCode());
        $this->assertEquals(
            "O paramentro email é inválido",
            json_decode($resp->getContent())->message
        );
    }

    public function testRetorna401CredencialInvalida()
    {

        $requestParams = [
            'email'=>'email_invaid@gmail.com',
            'password' =>'any_password'
        ];
        $autenticacao = $this->autenticaoControllerStub();
        $rota = Request::create('login', 'POST',$requestParams);
        $rota->headers->set('authorization', 'tova');
        $resp = $autenticacao->autenticar($rota);
        $this->assertEquals(401, $resp->getStatusCode());
        $this->assertEquals(
            'Crendecial inválida',
            json_decode($resp->getContent())->message
        );
    }
}
