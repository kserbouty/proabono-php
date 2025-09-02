<?php

namespace ProAbono;

/*
 * Common and Base classes
 */

use ProAbono\Api\ListBase;
use ProAbono\Api\ProAbonoCache;
use ProAbono\Api\ProAbonoError;
use ProAbono\Api\ProAbono;
use ProAbono\Api\Utils;

/**
 * Request / Response
 */

use ProAbono\Api\Request;
use ProAbono\Api\Response;

/*
 * Customers
 */

const PATH_CUSTOMER = '/v1/Customer';
const PATH_CUSTOMERS = '/v1/Customers';
const PATH_PAYMENT_SETTINGS = '/v1/CustomerSettingsPayment';
const PATH_BILLING_ADDRESS = '/v1/CustomerBillingAddress';

use ProAbono\Api\Customer;
use ProAbono\Api\CustomerList;
use ProAbono\Api\CustomerAddress;
use ProAbono\Api\CustomerPayment;

/**
 * Features
 */
const PATH_FEATURE = '/v1/Feature';
const PATH_FEATURES = '/v1/Features?SizePage=1000';

use ProAbono\Api\Feature;
use ProAbono\Api\FeatureList;

/**
 * Offers
 */
const PATH_OFFER = '/v1/Offer';
const PATH_OFFERS = '/v1/Offers?SizePage=1000';

use ProAbono\Api\Offer;
use ProAbono\Api\OfferList;

/**
 * Pricing
 */
const PATH_PRICING_USAGE = '/v1/Pricing/Usage';

use ProAbono\Api\Pricing;

/**
 * Subscriptions
 */
const PATH_SUBSCRIPTION = '/v1/Subscription';
const PATH_SUBSCRIPTIONS = '/v1/Subscriptions';

use ProAbono\Api\Subscription;
use ProAbono\Api\SubscriptionList;

/**
 * Usages
 */
const PATH_USAGE = '/v1/Usage';
const PATH_USAGES = '/v1/Usages';

use ProAbono\Api\Usage;
use ProAbono\Api\UsageList;
