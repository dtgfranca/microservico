<?php
namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use App\Types\Email;
use Exception;
use App\Services\HttpResponse;

class AutenticacaoController extends Controller
{
    private $authService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct($authService)
    {
      $this->authService = $authService ;
    }
    /**
     * @param Request $request
     *
     */
    public function autenticar(Request $request)
    {
        try{
            if (!$request->header('authorization')) {
                return response()->json([
                    'message' => 'A chave de autorização deve ser inforamda'
                ], HttpResponse::FORBIDEN);
            }
            if (!$request->has('password')) {
                return response()->json([
                    'message' => 'O paramentro senha não encontrado'
                ], HttpResponse::BAD_REQUEST);
            }
            if (!$request->has('email')) {
                return response()->json([
                    'message' => 'O paramentro email não encontrado'
                ], HttpResponse::BAD_REQUEST);
            }
            $email = new Email($request->get('email'));
            $token = $this->authService->auth($email, $request->get('password'));

            if (!$token) {
                return response()->json([
                    'message'=> 'Crendecial inválida'
                ], HttpResponse::UNAUTHORIZED);
            }
            return response()->json([
                'token' => "$token"
            ], HttpResponse::OK);

        }catch(Exception $e) {
            return response()->json([
                'message'=> 'Ocorreu algo inesperado'
            ], HttpResponse::SERVER_ERROR);
        }
    }
}
