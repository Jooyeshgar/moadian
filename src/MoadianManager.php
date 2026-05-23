<?php

namespace Jooyeshgar\Moadian;

use Jooyeshgar\Moadian\Exceptions\MoadianException;

class MoadianManager
{
    /**
     * The application instance.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * The array of resolved Moadian instances.
     *
     * @var array
     */
    protected $instances = [];

    /**
     * The default account name.
     *
     * @var string
     */
    protected $defaultAccount;

    /**
     * Create a new Moadian manager instance.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    public function __construct($app)
    {
        $this->app = $app;
        $this->defaultAccount = $app['config']['moadian.default'] ?? 'default';
    }

    /**
     * Get a Moadian instance for a specific account.
     *
     * @param  string|null  $name
     * @return \Jooyeshgar\Moadian\Moadian
     */
    public function account($name = null)
    {
        $name = $name ?: $this->defaultAccount;

        if (!isset($this->instances[$name])) {
            $this->instances[$name] = $this->resolve($name);
        }

        return $this->instances[$name];
    }

    /**
     * Create a Moadian instance with custom credentials.
     *
     * @param  string  $privateKey
     * @param  string  $certificate
     * @param  string  $username
     * @param  string|null  $baseUri
     * @return \Jooyeshgar\Moadian\Moadian
     */
    public function for($privateKey, $certificate, $username, $baseUri = null)
    {
        $baseUri = $baseUri ?? $this->app['config']['moadian.base_uri'] ?? 'https://tp.tax.gov.ir/requestsmanager/api/v2/';
        
        return new Moadian($privateKey, $certificate, $username, $baseUri);
    }

    /**
     * Create a Moadian instance from an array of configuration.
     *
     * @param  array  $config
     * @return \Jooyeshgar\Moadian\Moadian
     */
    public function fromConfig(array $config)
    {
        $privateKey = $this->loadKey($config['private_key_path'] ?? null, $config['private_key'] ?? null);
        $certificate = $this->loadCertificate($config['certificate_path'] ?? null, $config['certificate'] ?? null);
        $username = $config['username'] ?? throw new MoadianException("Username is required for Moadian account.");
        $baseUri = $config['base_uri'] ?? 'https://tp.tax.gov.ir/requestsmanager/api/v2/';

        return new Moadian($privateKey, $certificate, $username, $baseUri);
    }

    /**
     * Resolve a Moadian instance by account name.
     *
     * @param  string  $name
     * @return \Jooyeshgar\Moadian\Moadian
     * @throws \Jooyeshgar\Moadian\Exceptions\MoadianException
     */
    protected function resolve($name)
    {
        $config = $this->getAccountConfig($name);

        if (is_null($config)) {
            throw new MoadianException("Moadian account [{$name}] is not configured.");
        }

        return $this->fromConfig($config);
    }

    /**
     * Get the configuration for an account.
     *
     * @param  string  $name
     * @return array|null
     */
    protected function getAccountConfig($name)
    {
        $accounts = $this->app['config']['moadian.accounts'] ?? [];

        // If no accounts are configured, use legacy single-account config
        if (empty($accounts)) {
            return [
                'username' => $this->app['config']['moadian.username'],
                'private_key_path' => $this->app['config']['moadian.private_key_path'] ?? storage_path('app/keys/private.pem'),
                'certificate_path' => $this->app['config']['moadian.certificate_path'] ?? storage_path('app/keys/certificate.crt'),
                'base_uri' => $this->app['config']['moadian.base_uri'],
            ];
        }

        return $accounts[$name] ?? null;
    }

    /**
     * Load private key from path or direct content.
     *
     * @param  string|null  $path
     * @param  string|null  $content
     * @return string
     * @throws \Jooyeshgar\Moadian\Exceptions\MoadianException
     */
    protected function loadKey($path, $content)
    {
        if ($content) {
            return $content;
        }

        if ($path && file_exists($path)) {
            return file_get_contents($path);
        }

        throw new MoadianException("Private key not found. Provide either 'private_key_path' or 'private_key'.");
    }

    /**
     * Load certificate from path or direct content.
     *
     * @param  string|null  $path
     * @param  string|null  $content
     * @return string
     * @throws \Jooyeshgar\Moadian\Exceptions\MoadianException
     */
    protected function loadCertificate($path, $content)
    {
        if ($content) {
            $certificate = $content;
        } elseif ($path && file_exists($path)) {
            $certificate = file_get_contents($path);
        } else {
            throw new MoadianException("Certificate not found. Provide either 'certificate_path' or 'certificate'.");
        }

        return str_replace("\r\n", '', $certificate);
    }

    /**
     * Dynamically pass methods to the default account.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->account()->$method(...$parameters);
    }
}
