# ai\thirdwatch\LogoutApi

All URIs are relative to *https://localhost/event*

Method | HTTP request | Description
------------- | ------------- | -------------
[**logout**](LogoutApi.md#logout) | **POST** /v1/logout | Use logout to record when a user logs out.


# **logout**
> \ai\thirdwatch\Model\EventResponse logout($json)

Use logout to record when a user logs out.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: api_key
ai\thirdwatch\Configuration::getDefaultConfiguration()->setApiKey('X-THIRDWATCH-API-KEY', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// ai\thirdwatch\Configuration::getDefaultConfiguration()->setApiKeyPrefix('X-THIRDWATCH-API-KEY', 'Bearer');

$api_instance = new ai\thirdwatch\Api\LogoutApi();
$json = new \ai\thirdwatch\Model\Logout(); // \ai\thirdwatch\Model\Logout | Pass logout status to thirdwatch. Only `_userID` is required field. But this should contain logout info.

try {
    $result = $api_instance->logout($json);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling LogoutApi->logout: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **json** | [**\ai\thirdwatch\Model\Logout**](../Model/Logout.md)| Pass logout status to thirdwatch. Only &#x60;_userID&#x60; is required field. But this should contain logout info. |

### Return type

[**\ai\thirdwatch\Model\EventResponse**](../Model/EventResponse.md)

### Authorization

[api_key](../../README.md#api_key)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

