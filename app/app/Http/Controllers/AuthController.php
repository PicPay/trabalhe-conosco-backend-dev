<?php
namespace App\Http\Controllers;
use Validator;
use App\Profile;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Routing\Controller as BaseController;
class AuthController extends BaseController
{
	/**
	 * The request instance.
	 *
	 * @var \Illuminate\Http\Request
	 */
	private $request;

	/**
	 * Create a new controller instance.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return void
	 */
	public function __construct(Request $request) {
		$this->request = $request;
	}

	/**
	 * Create a new token.
	 *
	 * @param  \App\Profile   $profile
	 * @return string
	 */
	protected function jwt(Profile $profile) {
		$payload = [
			'iss' => "lumen-jwt", // Issuer of the token
			'sub' => $profile->id, // Subject of the token
			'iat' => time(), // Time when JWT was issued.
			'exp' => time() + 60*60 // Expiration time
		];

		return JWT::encode($payload, env('JWT_SECRET'));
	}

	/**
	 * Authenticate a profile and return the token if the provided credentials are correct.
	 *
	 * @param  \App\Profile   $profile
	 * @return mixed
	 */
	public function authenticate(Profile $profile) {
		$this->validate($this->request, [
			'email'     => 'required|email',
			'password'  => 'required'
		]);
		// Find the profile by email
		$profile = Profile::where('email', $this->request->input('email'))->first();
		if (!$profile) {
			return response()->json([
				'error' => 'Email does not exist.'
			], 400);
		}
		// Verify the password and generate the token
		if (Hash::check($this->request->input('password'), $profile->password)) {
			return response()->json([
				'token' => $this->jwt($profile)
			], 200);
		}
		// Bad Request response
		return response()->json([
			'error' => 'Email or password is wrong.'
		], 400);
	}
}
