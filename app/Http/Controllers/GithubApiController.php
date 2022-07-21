<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;
use Exception;

class GithubApiController extends Controller
{

  /**
   * @param request
   * @return object
   */
  public function fetchUsernames(Request $request)
  {
    $output = null;
    try {
      // Set key to be used in redis cache
      $key = $this->generateKey($request->search);
      
      /**
       * Check if key exist from Redis Cache
       */
      $githubCache = Redis::get($key);
      if(isset($githubCache)) {
        /**
         * Set output from Redis cache
         */
        $output = [
          'success' => true,
          'message' => 'Record from Redis Cache',
          'data' => json_decode($githubCache)
        ];
      } 
      else {
        /**
         * Call github api
         */
        $githubUsers = $this->callGithubApi($request->search);
        if($githubUsers === false) throw new Exception("Github username was not found", 1);
        
        /**
         * Build response
         */
        $buildData = $this->buildResponse($githubUsers);
        if($buildData === false) throw new Exception("Error in building response", 1);
        
        /**
         * Save Redis cache
         */
        $key = $this->generateKey($buildData['login']);
        Redis::set($key, json_encode($buildData), 'EX', 120); // Store for 2 minute

        /**
         * Set output
         */
        $output = [
          'success' => true,
          'message' => 'Record from Github API',
          'data' => $buildData
        ];
      }
    } catch (Exception $ex) {
      
      Log::error($ex->getMessage());

      $output = [
        'success' => false,
        'message' => $ex->getMessage()
      ];
    }

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

      $exec = curl_exec($ch);

      // Close connection
      curl_close($ch);

      /**
       * Check if we got curl connection error
       */
      if(curl_error($ch)) throw new Exception(curl_error($ch), 1);
      
      $response = json_decode($exec, true);
      /**
       * Validate if valid github user
       */
      if(isset($response['message'])) throw new Exception($response['message'], 1);
      
      return $response;
    } catch (Exception $ex) {
      // Logger
      Log::error($ex->getMessage());

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
      Log::error($ex->getMessage());
      
      return false;
    }
  }

  protected function generateKey($str) 
  {
    return 'github_' . $str;
  }
}
