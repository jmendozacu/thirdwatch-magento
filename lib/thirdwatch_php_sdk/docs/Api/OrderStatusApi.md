# Swagger\Client\OrderStatusApi

All URIs are relative to *https://localhost/event*

Method | HTTP request | Description
------------- | ------------- | -------------
[**orderStatus**](OrderStatusApi.md#orderStatus) | **POST** /v1/order_status | Use order_status to track the order processing workflow of a previously submitted order.


# **orderStatus**
> \Swagger\Client\Model\EventResponse orderStatus($json)

Use order_status to track the order processing workflow of a previously submitted order.

For example, order_status can be used to indicate that an order has been held for review, canceled due to suspected fraud, or fulfilled. This event can be called multiple times to record changes an order's status.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: api_key
Swagger\Client\Configuration::getDefaultConfiguration()->setApiKey('X-THIRDWATCH-API-KEY', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// Swagger\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('X-THIRDWATCH-API-KEY', 'Bearer');

$api_instance = new Swagger\Client\Api\OrderStatusApi();
$json = new \Swagger\Client\Model\OrderStatus(); // \Swagger\Client\Model\OrderStatus | Pass order status to thirdwatch. Only `_userID` is required field. But this should contain order info.

try {
    $result = $api_instance->orderStatus($json);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling OrderStatusApi->orderStatus: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **json** | [**\Swagger\Client\Model\OrderStatus**](../Model/OrderStatus.md)| Pass order status to thirdwatch. Only &#x60;_userID&#x60; is required field. But this should contain order info. |

### Return type

[**\Swagger\Client\Model\EventResponse**](../Model/EventResponse.md)

### Authorization

[api_key](../../README.md#api_key)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

