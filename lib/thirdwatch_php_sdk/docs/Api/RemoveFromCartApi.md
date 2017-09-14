# Swagger\Client\RemoveFromCartApi

All URIs are relative to *https://localhost/event*

Method | HTTP request | Description
------------- | ------------- | -------------
[**removeFromCart**](RemoveFromCartApi.md#removeFromCart) | **POST** /v1/remove_from_cart | Use remove_from_cart when a user removes an item from their shopping cart or list.


# **removeFromCart**
> \Swagger\Client\Model\EventResponse removeFromCart($json)

Use remove_from_cart when a user removes an item from their shopping cart or list.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: api_key
Swagger\Client\Configuration::getDefaultConfiguration()->setApiKey('X-THIRDWATCH-API-KEY', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Swagger\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('X-THIRDWATCH-API-KEY', 'Bearer');

$api_instance = new Swagger\Client\Api\RemoveFromCartApi();
$json = new \Swagger\Client\Model\RemoveFromCart(); // \Swagger\Client\Model\RemoveFromCart | Pass removed item info to thirdwatch. Only `_userID` is required field. But this should contain item info.

try {
    $result = $api_instance->removeFromCart($json);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling RemoveFromCartApi->removeFromCart: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **json** | [**\Swagger\Client\Model\RemoveFromCart**](../Model/RemoveFromCart.md)| Pass removed item info to thirdwatch. Only &#x60;_userID&#x60; is required field. But this should contain item info. |

### Return type

[**\Swagger\Client\Model\EventResponse**](../Model/EventResponse.md)

### Authorization

[api_key](../../README.md#api_key)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

