<?php

namespace Augustash\Api\Example;


class HttpClient
{
    const DATA_FORMAT_JSON = 'json';
    const DATA_FORMAT_XML = 'xml';

    /**
     * Example: https://foo.com/api
     * @var string
     */
    protected $baseUrl;

    /**
     * Example: 'bar'
     * @var string
     */
    protected $url;

    /**
     * GuzzleHttp\Client
     *
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * Class constructor
     */
    public function __construct(array $config = ["base_uri" => "http://foo.dev/api", "url" => "bar"])
    {
        if (empty($this->baseUrl) && !empty($config['base_uri'])) {
            $this->setBaseUrl($config['base_uri']);
        }

        if (empty($this->url) && !empty($config['url'])) {
            $this->setUrl($config['url']);
        }

        if (is_null($this->client)) {
            $this->getClient();
        }
    }


    /**
     * Make a GET request to http://foo.dev/bar and pass a person's name
     * as data and expect the response to include a string of "Hello :name"
     *
     * @param  string $name
     * @param  string $dataFormat # 'xml' or 'json'. Default is 'json'
     * @return GuzzleHttp\Psr7\Response
     */
    public function sayHello($name = '', $dataFormat = self::DATA_FORMAT_JSON)
    {
        try {
            $headers = $this->getDefaultHeaders();
            $client = $this->getClient();

            if ($dataFormat == self::DATA_FORMAT_XML) {
                $data = $this->formatDataAsXml($name);
                $headers['Accept'] = 'text/xml';
                // $headers['ContentType'] = 'text/xml';
            } else {
                $data = $this->formatDataAsJson($name);
            }


            $response = $client->request('GET', $this->getUrl(), [
                'headers' => $headers,
                'body' => $data
            ]);

            // $code = $response->getStatusCode(); // 200
            // $reason = $response->getReasonPhrase(); // OK
            // echo $response->getBody();

            return $response;

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Returns an instance of the GuzzleHttp\Client
     * with a pre-configured base_uri
     *
     * Warning: Clients are immutable in Guzzle 6, which means that you
     * cannot change the defaults used by a client after it's created.
     * @see http://docs.guzzlephp.org/en/latest/quickstart.html#making-a-request
     *
     * @param  array $config
     * @return \GuzzleHttp\Client
     */
    public function getClient(array $config = [])
    {
        if (empty($config)) {
            $config = [
                'base_uri' => $this->getBaseUrl()
            ];
        }

        if (is_null($this->client)) {
            $this->client = new \GuzzleHttp\Client($config);
        }

        return $this->client;
    }

    public function getDefaultHeaders()
    {
        return [
            'User-Agent'    => 'testing/1.0',
            'Accept'        => 'application/json',
            'X-Foo'         => ['Bar', 'Baz']
        ];
    }

    public function formatDataAsJson($data)
    {
        if (!is_array($data)) {
            $data = ['name' => $data];
        }

        return json_encode($data);
    }

    /**
     * Format the string|array data into a valid XML object
     * and convert it to a string
     *
     * @param  array|string $data
     * @return string
     */
    public function formatDataAsXml($data)
    {
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><request></request>');

        if (is_array($data)) {
            foreach($data as $key => $value) {
                $xml->addChild($key, $value);
            }
        } else {
            $xml->addChild('name', $data);
        }

        $xmlString = $xml->asXML();

        return $xmlString;
    }



    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;
        return $this;
    }

    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    public function getUrl()
    {
        return $this->url;
    }

}
