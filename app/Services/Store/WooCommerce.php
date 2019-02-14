<?php

declare(strict_types = 1);

namespace App\Services\Store;

use App\Contracts\Store\Product as ProductContract;
use App\Product;
use App\Store;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

class WooCommerce implements ProductContract
{
    /**
     * Store model.
     *
     * @var Store
     */
    protected $store;
    
    /**
     * GuzzleHttp client instance.
     * 
     * @var Client
     */
    protected $client;
    
    /**
     * WooCommerce REST API URI base.
     * 
     * @var string
     */
    protected $uri = 'wp-json/wc/v3/';

    /**
     * Constructor.
     * 
     * @param   Store $store
     */
    public function __construct(Store $store)
    {
        $this->store = $store;
        
        $this->client = new Client([
            'base_uri' => $this->store->base_url . $this->uri,
            'handler' => $this->handler()
        ]);
    }
    
    /**
     * Generate handler for authorizing API requests.
     * 
     * @return  HandlerStack
     */
    private function handler()
    {
        $stack = HandlerStack::create();
        $stack->push(new Oauth1($this->oauthConfig()));
        
        return $stack;
    }
    
    /**
     * Oauth configuration for specific WooCommerce store.
     * 
     * @return  array
     */
    private function oauthConfig()
    {
        $id = $this->store->id ?? 0;
        $key = env(sprintf('STORE_%d_CK', $id));
        $secret = env(sprintf('STORE_%d_CS', $id));
        
        $config = [
            'consumer_key' => $key,
            'consumer_secret' => $secret,
            'token_secret' => '',
            'token' => '',
            'request_method' => Oauth1::REQUEST_METHOD_QUERY,
            'signature_method' => Oauth1::SIGNATURE_METHOD_HMAC
        ];
        
        return $config;
    }
    
    /**
     * Transform product to WooCommerce product.
     * 
     * @param   Product $product
     * @return  array
     */
    private function transformProduct(Product $product)
    {
        return [
            'name' => $product->name,
            'sku' => $product->sku,
            'regular_price' => $product->price,
            'weight' => $product->weight
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function createProduct(Product $product): int
    { 
        $product = $this->transformProduct($product);
        
        try {
            $response = $this->client->post('products', [
                'auth' => 'oauth',
                'form_params' => $product
            ]);
            
            $result = json_decode($response->getBody()->getContents());
            
            return (int) $result->id;          
        } catch (RequestException $e) {}
        
        return 0;
    }
}