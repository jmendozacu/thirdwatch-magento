# ai\thirdwatch\SubmitReviewApi

All URIs are relative to *https://localhost/event*

Method | HTTP request | Description
------------- | ------------- | -------------
[**submitReview**](SubmitReviewApi.md#submitReview) | **POST** /v1/submit_review | Use submit_review when a user-submitted review of a product or seller.


# **submitReview**
> \ai\thirdwatch\Model\EventResponse submitReview($json)

Use submit_review when a user-submitted review of a product or seller.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: api_key
ai\thirdwatch\Configuration::getDefaultConfiguration()->setApiKey('X-THIRDWATCH-API-KEY', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// ai\thirdwatch\Configuration::getDefaultConfiguration()->setApiKeyPrefix('X-THIRDWATCH-API-KEY', 'Bearer');

$api_instance = new ai\thirdwatch\Api\SubmitReviewApi();
$json = new \ai\thirdwatch\Model\SubmitReview(); // \ai\thirdwatch\Model\SubmitReview | Pass review to thirdwatch. Only `_userID` is required field. But this should contain review info.

try {
    $result = $api_instance->submitReview($json);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling SubmitReviewApi->submitReview: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **json** | [**\ai\thirdwatch\Model\SubmitReview**](../Model/SubmitReview.md)| Pass review to thirdwatch. Only &#x60;_userID&#x60; is required field. But this should contain review info. |

### Return type

[**\ai\thirdwatch\Model\EventResponse**](../Model/EventResponse.md)

### Authorization

[api_key](../../README.md#api_key)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

