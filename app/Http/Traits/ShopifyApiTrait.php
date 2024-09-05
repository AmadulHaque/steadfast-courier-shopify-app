<?php
namespace App\Http\Traits;

trait ShopifyApiTrait
{
    private $shop;

    public function shop($shop = null)
    {
        if (!$this->shop):
            $this->shop = ($shop ? $shop : auth()->user());
        endif;
    }

    //helper function to do shopify api rest request
    public function api_request($method = "GET", $api = "", $api_get_fields = null, $api_post_fields = null, $api_required_fields = null, $shop = null)
    {
        $this->shop($shop);
        $response = $this->shop->api()->rest($method, $this->makeUrl($api, $api_get_fields), $api_post_fields);
        if ($response['errors'] === true):
            return false;
        endif;
        if ($api_required_fields):
            foreach ($api_required_fields as $key => $value) {
                if (!isset($response[$value])):
                    return $response;
                endif;
                $response = $response[$value];
            }
            return $response;
        endif;
        return $response;
    }

    public function makeUrl($api, $data = null)
    {
        $url = [];
        foreach (config("shopifyApi.apis.$api") as $value) {
            if ($data):
                $url[] = $value;
                $url[] = $data;
                $data = null;
            else:
                $url[] = $value;
            endif;
        }
        return implode('', $url);
    }

    //helper function to do shopify api graphql request
    public function graph_api_request($api = "", $api_get_fields = null, $api_post_fields = null, $api_required_fields = null, $shop = null)
    {
        $this->shop($shop);
        if ($api_post_fields):
            $response = $this->shop->api()->graph($this->makeGraphUrl($api, $api_get_fields), $api_post_fields);
        else:
            $response = $this->shop->api()->graph($this->makeGraphUrl($api, $api_get_fields));
        endif;
        if ($response['errors'] === true):
            return $response['errors'];
        endif;
        if ($api_required_fields):
            return $this->getRequiredFields($api_required_fields, $response);
        endif;
        return $response;
    }

    public function makeGraphUrl($api, $data = null)
    {
        $url = [];
        foreach (config("shopifyApi.graphQl.$api") as $key => $aPart) {
            if ($data):
                $url[] = $aPart;
                if (isset($data[$key])):
                    $url[] = $data[$key];
                endif;
            else:
                $url[] = $aPart;
            endif;
        }
        return implode('', $url);
    }
}
