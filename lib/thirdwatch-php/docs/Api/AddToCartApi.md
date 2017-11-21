# ai\thirdwatch\AddToCartApi

All URIs are relative to *https://localhost/event*

Method | HTTP request | Description
------------- | ------------- | -------------
[**addToCart**](AddToCartApi.md#addToCart) | **POST** /v1/add_to_cart | Use add_to_cart when a user adds an item to their shopping cart or list.


# **addToCart**
> \ai\thirdwatch\Model\EventResponse addToCart($json)

Use add_to_cart when a user adds an item to their shopping cart or list.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: api_key
ai\thirdwatch\Configuration::getDefaultConfiguration()->setApiKey('X-THIRDWATCH-API-KEY', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// ai\thirdwatch\Configuration::getDefaultConfiguration()->setApiKeyPrefix('X-THIRDWATCH-API-KEY', 'Bearer');

$api_instance = new ai\thirdwatch\Api\AddToCartApi();
$json = new \ai\thirdwatch\Model\AddToCart(); // \ai\thirdwatch\Model\AddToCart | Pass added item info to thirdwatch. Only `_userID` is required field. But this should contain item info.

try {
    $result = $api_instance->addToCart($json);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling AddToCartApi->addToCart: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **json** | [**\ai\thirdwatch\Model\AddToCart**](../Model/AddToCart.md)| Pass added item info to thirdwatch. Only &#x60;_userID&#x60; is required field. But this should contain item info. |

### Return type

[**\ai\thirdwatch\Model\EventResponse**](../Model/EventResponse.md)

### Authorization

[api_key](../../README.md#api_key)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

