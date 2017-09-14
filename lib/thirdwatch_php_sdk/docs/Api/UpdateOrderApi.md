# Swagger\Client\UpdateOrderApi

All URIs are relative to *https://localhost/event*

Method | HTTP request | Description
------------- | ------------- | -------------
[**updateOrder**](UpdateOrderApi.md#updateOrder) | **POST** /v1/update_order | Update details of an existing order.


# **updateOrder**
> \Swagger\Client\Model\EventResponse updateOrder($json)

Update details of an existing order.

* This event contains the same fields as ```create_order```. * The existing order will be completely replaced by the values sent in `update_order`. Be sure to specify all values for the order, not just those that changed. * If no matching `_orderId` found, a new order will be created.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: api_key
Swagger\Client\Configuration::getDefaultConfiguration()->setApiKey('X-THIRDWATCH-API-KEY', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Swagger\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('X-THIRDWATCH-API-KEY', 'Bearer');

$api_instance = new Swagger\Client\Api\UpdateOrderApi();
$json = new \Swagger\Client\Model\UpdateOrder(); // \Swagger\Client\Model\UpdateOrder | Update details of an existing order. Only `_userID` is required field. But this should contain existing order info.

try {
    $result = $api_instance->updateOrder($json);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling UpdateOrderApi->updateOrder: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **json** | [**\Swagger\Client\Model\UpdateOrder**](../Model/UpdateOrder.md)| Update details of an existing order. Only &#x60;_userID&#x60; is required field. But this should contain existing order info. |

### Return type

[**\Swagger\Client\Model\EventResponse**](../Model/EventResponse.md)

### Authorization

[api_key](../../README.md#api_key)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

