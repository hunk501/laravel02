<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Exception;

class GithubApiController extends Controller
{

  /**
   * @param request
   * @return object
   */
  public function fetchUsernames(Request $request)
  {

    // Check if existing in Redis
    // if not callGithubApi
    $response = $this->callGithubApi($request->search);

    // Build response
    $data = $this->buildResponse($response);
    $output = ($data !== false) ? $data : [];

    return response()->json($output, 200);
  }

  protected function callGithubApi($username)
  {
    try {
      $url = "https://api.github.com/users/$username";

      $ch = curl_init();

      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_USERAGENT, 'Awesome-Octocat-App');

      $response = curl_exec($ch);

      curl_close($ch);

      if(curl_error($ch)) throw new Exception(curl_error($ch), 1);
      
      return json_decode($response, true);
    } catch (Exception $ex) {
      // Logger

      return false;
    }
  }

  protected function buildResponse($response) 
  {
    try {
      return [
        'name' => $response['name'],
        'login' => $response['login'],
        'company' => $response['company'],
        'followers' => $response['followers'],
        'repositories' => $response['public_repos'],
        'avarage_follower' => round(($response['followers'] / $response['public_repos']), 2),
      ];
    } catch (\Throwable $th) {
      // Logger
      return false;
    }
  }
}
