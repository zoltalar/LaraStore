<?php

declare(strict_types = 1);

namespace App\Services\Store;

use App\Contracts\Store\Product as ProductContract;
use App\Product;
use App\Store;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\RequestOptions;

class Magento implements ProductContract
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
     * Magento REST API URI base.
     * 
     * @var string
     */
    protected $uri = 'rest/V1/';

    /**
     * Constructor.
     * 
     * @param   Store $store
     */
    public function __construct(Store $store)
    {
        $this->store = $store;
        
        $this->client = new Client([
            'base_uri' => $this->store->base_url . $this->uri
        ]);
    }
    
    /**
     * Get authorization token.
     * 
     * @return  string|null
     */
    private function getToken()
    {
        try {
            $request = $this->client->post('integration/admin/token', [                
                'query' => $this->credentials()
            ]);
            
            return json_decode($request->getBody()->getContents());       
        } catch (RequestException $e) {}
        
        return null;
    }
    
    /**
     * Credentials for specific Magento store.
     * 
     * @return  array
     */
    private function credentials()
    {
        $id = $this->store->id ?? 0;
        
        return [
            'username' => env(sprintf('STORE_%d_USERNAME', $id)),
            'password' => env(sprintf('STORE_%d_PASSWORD', $id))
        ];
    }
    
    /**
     * Transform product to Magento product.
     * 
     * @param   Product $product
     * @return  array
     */
    private function transformProduct(Product $product)
    {
        return [
            'name' => $product->name,
            'sku' => $product->sku,
            'attribute_set_id' => 9,            
            'price' => $product->price,
            'status' => $product->status,
            'visibility' => 1,
            'type_id' => 'simple',
            'weight' => $product->weight
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function createProduct(Product $product): int
    {
        $token = $this->getToken();        
        $product = $this->transformProduct($product);
        
        try {
            $response = $this->client->post('products', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token
                ],
                RequestOptions::JSON => [
                    'product' => $product
                ]
            ]);
            
            $result = json_decode($response->getBody()->getContents());
            
            return (int) $result->id;          
        } catch (RequestException $ex) {}
        
        return 0;
    }
}