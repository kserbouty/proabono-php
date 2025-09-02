<?php

/*
 * Common and Base classes
 */
require_once(__DIR__ . '/proabono/ListBase.php');
require_once(__DIR__ . '/proabono/ProAbonoCache.php');
require_once(__DIR__ . '/proabono/ProAbonoError.php');
require_once(__DIR__ . '/proabono/ProAbono.php');
require_once(__DIR__ . '/proabono/Utils.php');

/**
 * Request / Response
 */
require_once(__DIR__ . '/proabono/Request.php');
require_once(__DIR__ . '/proabono/Response.php');

/*
 * Customers
 */
const PATH_CUSTOMER = '/v1/Customer';
const PATH_CUSTOMERS = '/v1/Customers';
const PATH_PAYMENT_SETTINGS = '/v1/CustomerSettingsPayment';
const PATH_BILLING_ADDRESS = '/v1/CustomerBillingAddress';

require_once(__DIR__ . '/proabono/Customer.php');
require_once(__DIR__ . '/proabono/CustomerList.php');
require_once(__DIR__ . '/proabono/CustomerAddress.php');
require_once(__DIR__ . '/proabono/CustomerPayment.php');

/**
 * Features
 */
const PATH_FEATURE = '/v1/Feature';
const PATH_FEATURES = '/v1/Features?SizePage=1000';

require_once(__DIR__ . '/proabono/Feature.php');
require_once(__DIR__ . '/proabono/FeatureList.php');

/**
 * Offers
 */
const PATH_OFFER = '/v1/Offer';
const PATH_OFFERS = '/v1/Offers?SizePage=1000';

require_once(__DIR__ . '/proabono/Offer.php');
require_once(__DIR__ . '/proabono/OfferList.php');

/**
 * Pricing
 */
const PATH_PRICING_USAGE = '/v1/Pricing/Usage';

require_once(__DIR__ . '/proabono/Pricing.php');

/**
 * Subscriptions
 */
const PATH_SUBSCRIPTION = '/v1/Subscription';
const PATH_SUBSCRIPTIONS = '/v1/Subscriptions';

require_once(__DIR__ . '/proabono/Subscription.php');
require_once(__DIR__ . '/proabono/SubscriptionList.php');

/**
 * Usages
 */
const PATH_USAGE = '/v1/Usage';
const PATH_USAGES = '/v1/Usages';

require_once(__DIR__ . '/proabono/Usage.php');
require_once(__DIR__ . '/proabono/UsageList.php');
