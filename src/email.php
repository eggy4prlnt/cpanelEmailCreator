<?php


class cpanelEmailCreator
{
    public $url, $username, $password;

    function loginCpanel($cookie = null)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url.'/login');
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-type: application/x-www-form-urlencoded'
        ]);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "user=$this->username&pass=$this->password&goto_uri=%2F");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie); // Cookie aware

        if ($cookie) {
            curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
        } else {
            curl_setopt($ch, CURLOPT_COOKIEJAR, md5($this->username).".txt");
        }

        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36");
        $exec = curl_exec($ch);
        curl_close($ch);
        
        if (preg_match('/Access Denied/', $exec)) {
            $resp = json_encode(array(
                'status' => 0,
                'message' => 'username or password incorrect'
            ));
        } else {
            preg_match_all('/location: (.+)/', $exec, $hasil);
            $explode = explode("/", $hasil[1][0]);
            $resp = json_encode(array(
                'status' => 1,
                'redirectTo' => $hasil[1][0],
                'cpanelUser' => $explode[1]
            ));
        }

        return $resp;

    }

    public function createEmail($cpanelUser, $domain, $username, $password, $quota = 1024)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$this->url/$cpanelUser/execute/Email/add_pop");
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "email=$username&domain=$domain&password=$password&quota=$quota&send_welcome_email=1");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_COOKIEFILE, md5($this->username).".txt"); // Cookie aware
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36");
        $exec = curl_exec($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $body = substr($exec, $header_size);
        curl_close($ch);

        $decode = json_decode($body);
        if ($decode->status == 0) {
            $resp = json_encode(array(
                "status" => 0,
                "message" => $decode->errors[0]
            ));
        } elseif($decode->status == 1) {
            $resp = json_encode(array(
                "status" => 1,
                "message" => "Account successfully created"
            ));
        } 

        return $resp;
    }
}