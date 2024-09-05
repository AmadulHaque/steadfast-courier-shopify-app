<?php
namespace App\Http\Traits;

use App\Http\Traits\ShopifyApiTrait;

trait ShopifyTrait
{

    use ShopifyApiTrait;

    //helper function to do shopify shop api request
    public function shopApi($shop = null)
    {
        $this->shop($shop);
        return $this->api_request('GET', "getShopProperties");
    }

    //helper function to do shopify create page api request
    public function createPage($data, $shop = null)
    {
        $this->shop($shop);
        return $this->api_request('POST', "createPage", null, $data);
    }

    //helper function to do shopify delete page api request
    public function deletePage($pageId, $shop = null)
    {
        $this->shop($shop);
        return $this->api_request("DELETE", "deletePage", $pageId);
    }

    //helper function to do shopify create script tag api request
    public function createScriptTag($data, $shop = null)
    {
        $this->shop($shop);
        return $this->api_request('POST', "createScriptTag", null, $data);
    }

    //helper function to do shopify delete script tag api request
    public function deleteScriptTag($scriptTagId, $shop = null)
    {
        $this->shop($shop);
        return $this->api_request("DELETE", "deleteScriptTag", $scriptTagId);
    }

}
