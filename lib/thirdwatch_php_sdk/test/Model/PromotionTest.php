<?php
/**
 * PromotionTest
 *
 * PHP version 5
 *
 * @category Class
 * @package  Swagger\Client
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * Thirdwatch API
 *
 * The first version of the Thirdwatch API is an exciting step forward towards making it easier for developers to pass data to Thirdwatch.   # Introduction Once you've [registered your website/app](https://thirdwatch.ai) it's easy to start sending data to Thirdwatch.  All endpoints are only accessible via https and are located at `api.thirdwatch.ai`. For instance: you can send event at the moment by ```HTTP POST``` Request to the following URL with your API key in ```Header``` and ```JSON``` data in request body. ```   https://api.thirdwatch.ai/event/v1 ``` Every API request must contain ```API Key``` in header value ```X-THIRDWATCH-API-KEY```  Every event must contain your ```_userId``` (if this is not available, you can alternatively provide a ```_sessionId``` value also in ```_userId```).  # Score API The Score API is use to get an up to date cutomer trust score after you have sent transaction event and order successful. This API will provide the riskiness score of the order with reasons. Some examples of when you may want to check the score are before:    - Before Shippement of a package   - Finalizing a money transfer   - Giving access to a prearranged vacation rental   - Sending voucher on mail    ```   https://api.thirdwatch.ai/neo/v1/score?api_key=<your api key>&order_id=<Order id> ```  According to Score you can decide to take action Approve or Reject. Orders with score more than 70 will consider as Riskey orders. We'll provide some reasons also in rules section.  ## Response score API  ``` {   \"order_id\": \"OCT45671\",   \"user_id\": \"ajay_245\",   \"order_timestamp\": \"2017-05-09T09:40:45.717Z\",   \"score\": 82,   \"flag\": \"red\",     -\"reasons\": [     {         \"name\": \"_numOfFailedTransactions\",         \"display_name\": \"Number of failed transactions\",         \"flag\": \"green\",         \"value\": \"0\",         \"is_display\": true       },       {         \"name\": \"_accountAge\",         \"display_name\": \"Account age\",         \"flag\": \"red\",         \"value\": \"0\",         \"is_display\": true       },        {         \"name\": \"_numOfOrderSameIp\",         \"display_name\": \"Number of orders from same IP\",         \"flag\": \"red\",         \"value\": \"11\",         \"is_display\": true       }     ] } ```
 *
 * OpenAPI spec version: 0.0.1
 * 
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 *
 */

/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Please update the test case below to test the model.
 */

namespace Swagger\Client;

/**
 * PromotionTest Class Doc Comment
 *
 * @category    Class */
// * @description The Promotion field type generically models different kinds of promotions such as referrals, coupons, free trials, etc. The value must be a nested JSON object which you populate with the appropriate information to describe the promotion. Not all sub-fields will likely apply to a given promotion. Populate only those that apply.  A promotion can be added when creating or updating an account, creating or updating an order, or on its own using the add_promotion event. The promotion object supports both monetary (e.g. 500 coupon on first order) and non-monetary (e.g. \&quot;100 in points to refer a friend\&quot;).
/**
 * @package     Swagger\Client
 * @author      Swagger Codegen team
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class PromotionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Setup before running any test case
     */
    public static function setUpBeforeClass()
    {
    }

    /**
     * Setup before running each test case
     */
    public function setUp()
    {
    }

    /**
     * Clean up after running each test case
     */
    public function tearDown()
    {
    }

    /**
     * Clean up after running all test cases
     */
    public static function tearDownAfterClass()
    {
    }

    /**
     * Test "Promotion"
     */
    public function testPromotion()
    {
    }

    /**
     * Test attribute "_promotion_id"
     */
    public function testPropertyPromotionId()
    {
    }

    /**
     * Test attribute "_status"
     */
    public function testPropertyStatus()
    {
    }

    /**
     * Test attribute "_description"
     */
    public function testPropertyDescription()
    {
    }

    /**
     * Test attribute "_amount"
     */
    public function testPropertyAmount()
    {
    }

    /**
     * Test attribute "_min_purchase_amount"
     */
    public function testPropertyMinPurchaseAmount()
    {
    }

    /**
     * Test attribute "_referrer_user_id"
     */
    public function testPropertyReferrerUserId()
    {
    }

    /**
     * Test attribute "_failure_reason"
     */
    public function testPropertyFailureReason()
    {
    }

    /**
     * Test attribute "_percentage_off"
     */
    public function testPropertyPercentageOff()
    {
    }

    /**
     * Test attribute "_currency_code"
     */
    public function testPropertyCurrencyCode()
    {
    }

    /**
     * Test attribute "_type"
     */
    public function testPropertyType()
    {
    }
}