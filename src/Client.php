<?php namespace Wongpinter\GoogleClient;
/**
 * Created By: Sugeng
 * Date: 10/5/17
 * Time: 10:48
 */

use Wongpinter\GoogleClient\Exceptions\UnknownGoogleServiceException;

class Client
{
    protected $client;
    protected $config;
    protected $credentialFile;

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->credentialFile = $config['credential_file'];

        $this->client = new \Google_Client();

        $this->authorization();
    }

    public function callback($code)
    {
        $folder_path = dirname($this->credentialFile);

        if ( !is_dir($folder_path) ) {
            mkdir($folder_path, 0777, true);
        }

        $accessToken = $this->client->fetchAccessTokenWithAuthCode($code);

        file_put_contents($this->credentialFile, json_encode($accessToken));
    }

    public function service($service_name)
    {
        $this->credential();

        $service = 'Google_Service_' . ucfirst($service_name);

        if (class_exists($service)) {
            $class = new \ReflectionClass($service);

            return $class->newInstance($this->client);
        }

        throw new UnknownGoogleServiceException("Google API Service for {$service} not found!");
    }

    public function credential()
    {
        if ($accessToken = $this->checkCredentialToken()) {

            $this->client->setAccessToken($accessToken);

            if ($this->client->isAccessTokenExpired()) {
                $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
                file_put_contents($this->credentialFile, json_encode($this->client->getAccessToken()));
            }
        } else {
            $this->createAuthenticationUrl();
        }
    }

    public function client()
    {
        return $this->client;
    }

    protected function checkCredentialToken()
    {
        if (file_exists($this->credentialFile)) {
            return json_decode(file_get_contents($this->credentialFile), true);
        }

        return false;
    }

    protected function createAuthenticationUrl()
    {
        header("Location: {$this->client->createAuthUrl()}");
        die;
    }

    protected function authorization()
    {
        $this->client->setApplicationName($this->config['application_name']);
        $this->client->setClientId($this->config['client_id']);
        $this->client->setClientSecret($this->config['client_secret']);
        $this->client->setRedirectUri($this->config['redirected_uri']);
        $this->client->setApprovalPrompt($this->config['approval_prompt']);
        $this->client->setScopes($this->config['scopes']);
        $this->client->setAccessType($this->config['access_type']);
        $this->client->setDeveloperKey($this->config['developer_key']);
    }
}