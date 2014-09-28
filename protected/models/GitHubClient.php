<?php
/*
 * Created to interact with GitHub API
 * by Angelo Scalabroni
 * @property string $username
 * @property string $password
 */
class GitHubClient {
    
    public $username;
    public $password;
    
    public function __construct($githubaccount) {
        $this->setCredentials($githubaccount->GitHubUsername, $githubaccount->GitHubPassword);
    }

    private function setCredentials($username, $password) {
        $this->username = $username;
        $this->password = $password;
    }
    
    

    public function getRepoList() {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'https://api.github.com/users/' . $this->username . '/repos',
            CURLOPT_USERAGENT => 'Get User Repos',
            CURLOPT_USERPWD => $this->username . ':' . GitHubAccount::decryptPassword($this->password)
        ));
        // Send the request & save response to $resp
        $resp = curl_exec($curl);
        if (!curl_exec($curl)) {
            curl_close($curl);
            return false;
        } else {
            curl_close($curl);
            return json_decode($resp);
        }
    }
    
    public function checkUserCredentials() {
        $curl = curl_init();  
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_VERBOSE => 1,
            CURLOPT_HEADER => 1,
            CURLOPT_URL => 'https://api.github.com',
            CURLOPT_USERAGENT => 'Check User Credentials',
            CURLOPT_USERPWD => $this->username . ':' . GitHubAccount::decryptPassword($this->password)
        ));
        // Send the request & save response to $resp
        $resp = curl_exec($curl);
        if (!curl_exec($curl)) {
            curl_close($curl);
            throw new Exception('Server Failed Execution');
        } 
        $headers = $this->http_parse_headers($resp);
        if ($headers['Status'] != "200 OK") {
            return false;
        } else {
            return true;
        }
    }
    
    public function http_parse_headers($raw_headers)
    {
        $headers = array();
        $key = ''; // [+]

        foreach(explode("\n", $raw_headers) as $i => $h)
        {
            $h = explode(':', $h, 2);

            if (isset($h[1]))
            {
                if (!isset($headers[$h[0]]))
                    $headers[$h[0]] = trim($h[1]);
                elseif (is_array($headers[$h[0]]))
                {
                    $headers[$h[0]] = array_merge($headers[$h[0]], array(trim($h[1]))); // [+]
                }
                else
                {
                    $headers[$h[0]] = array_merge(array($headers[$h[0]]), array(trim($h[1]))); // [+]
                }

                $key = $h[0]; // [+]
            }
            else // [+]
            { // [+]
                if (substr($h[0], 0, 1) == "\t") // [+]
                    $headers[$key] .= "\r\n\t".trim($h[0]); // [+]
                elseif (!$key) // [+]
                    $headers[0] = trim($h[0]);trim($h[0]); // [+]
            } // [+]
        }

        return $headers;
    }
    
    

}
