# SSLCommerz Payment Gateway Package for Laravel

[![Latest Stable Version](https://poser.pugx.org/dgvai/laravel-sslcommerz/v/stable)](https://packagist.org/packages/dgvai/laravel-sslcommerz)
[![Total Downloads](https://poser.pugx.org/dgvai/laravel-sslcommerz/downloads)](https://packagist.org/packages/dgvai/laravel-sslcommerz)
[![Latest Unstable Version](https://poser.pugx.org/dgvai/laravel-sslcommerz/v/unstable)](https://packagist.org/packages/dgvai/laravel-sslcommerz)
[![License](https://poser.pugx.org/dgvai/laravel-sslcommerz/license)](https://packagist.org/packages/dgvai/laravel-sslcommerz)
[![Monthly Downloads](https://poser.pugx.org/dgvai/laravel-sslcommerz/d/monthly)](https://packagist.org/packages/dgvai/laravel-sslcommerz)
[![Daily Downloads](https://poser.pugx.org/dgvai/laravel-sslcommerz/d/daily)](https://packagist.org/packages/dgvai/laravel-sslcommerz)
[![composer.lock](https://poser.pugx.org/dgvai/laravel-sslcommerz/composerlock)](https://packagist.org/packages/dgvai/laravel-sslcommerz)

This package is built for [SSLCommerz](https://www.sslcommerz.com) online payment gateway in Bangladesh for Laravel 5.5+, 6.x and 7.x. (not tested for lower versions (< 5.5))

## Contents

- [Installation](#installation)
	- [Publish Configuration](#publish-configuration)
	- [Setup and Configure](#setup-and-configure)
- [Usage](#usage)
    - [Make Payment](#make-payment)
    - [Refund Process](#refund-process)
    - [Transaction Query](#transaction-query)
- [Available Methods](#available-methods)
- [Changelog](#changelog)
- [License](#license)

## Installation

You can install the package via composer:

``` bash
    composer require dgvai/laravel-sslcommerz
```

### Publish Configuration

Publish configuration file

```bash
    php artisan vendor:publish --tag=sslc-config
```

### Setup and configure

Update your app environment (.env) 
```
    SSLC_STORE_ID           =   [YOUR SSLCOMMERZ STORE_ID]
    SSLC_STORE_PASSWORD     =   [YOUR SSLCOMMERZ STORE_ID]
    SSLC_STORE_CURRENCY     =   [STORE CURRENCY eg. BDT]
    SSLC_ROUTE_SUCCESS      =   [route name of success_url, eg: payment.success]
    SSLC_ROUTE_FAILURE      =   [eg: payment.failure]
    SSLC_ROUTE_CANCE        =   [eg: payment.cancel]
    SSLC_ROUTE_IPN          =   [eg: payment.ipn]
    SSLC_ALLOW_LOCALHOST    =   [TRUE/FALSE]
```
**NOTE** SSLC_ROUTE_* variables are route name() not url()

Create four ``POST`` routes for SSLCommerz
```php
    Route::post('sslcommerz/success','PaymentController@success')->name('payment.success');
    Route::post('sslcommerz/failure','PaymentController@failure')->name('failure');
    Route::post('sslcommerz/cancel','PaymentController@cancel')->name('cancel');
    Route::post('sslcommerz/ipn','PaymentController@ipn')->name('payment.ipn');
```
**NOTE** These named routes are being used in .env file

Add exception in ``app\Http\Middleware\VerifyCsrfToken.php`` 
```php
    protected $except = [
        'sslcommerz/*'
    ];
```
**NOTE** This will be the initial group of those four routes

After done configuraing
```bash
    php artisan config:cache
```

## Usage

### Make Payment
Now you can call for payment in you controller method:

``` php

use DGvai\SSLCommerz\SSLCommerz;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    public function order()
    {
        ...
        //  DO YOU ORDER SAVING PROCESS TO DB OR ANYTHING
        ...

        $sslc = new SSLCommerz();
        $sslc->amount(20)
            ->trxid('DEMOTRX123')
            ->product('Demo Product Name')
            ->customer('Customer Name','custemail@email.com');
        return $sslc->make_payment();

        /**
         * 
         *  USE:  $sslc->make_payment(true) FOR CHECKOUT INTEGRATION
         * 
         * */
    }

    public function success(Request $request)
    {
        $validate = SSLCommerz::validate_payment($request);
        if($validate)
        {
            $bankID = $request->bank_tran_id;   //  KEEP THIS bank_tran_id FOR REFUNDING ISSUE
            ...
            //  Do the rest database saving works
            //  take a look at dd($request->all()) to see what you need
            ...
        }
    }

    public function failure(Request $request)
    {
        ...
        //  do the database works
        //  also same goes for cancel()
        //  for IPN() you can leave it untouched or can follow
        //  official documentation about IPN from SSLCommerz Panel
        ...
    }
}
```
**NOTE** This is the minimalist basic need to perform a payment.

### Refund Process
Also you can call for Refund Request and check Refund State
```php

    public function refund($bankID)
    {
        /** 
         * SSLCommerz::refund($bank_trans_id, $amount [,$reason])
         */

        $refund = SSLCommerz::refund($bankID,$refund_amount);

        if($refund->status)
        {
            /**
             * States:
             * success : Refund request is initiated successfully
             * failed : Refund request is failed to initiate
             * processing : The refund has been initiated already
            */

            $state  = $refund->refund_state;

            /**
             * RefID will be used for post-refund status checking
            */

            $refID  = $refund->ref_id;

            /**
             *  To get all the outputs
            */

            dd($refund->output);
        }
        else 
        {
            return $refund->message;
        }
    }

    public function check_refund_status($refID)
    {
        $refund = SSLCommerz::query_refund($refID);
	
        if($refund->status)
        {
            /**
             * States:
             * refunded : Refund request has been proceeded successfully
             * processing : Refund request is under processing
             * cancelled : Refund request has been proceeded successfully
            */

            $state  = $refund->refund_state;

            /**
             * RefID will be used for post-refund status checking
            */

            $refID  = $refund->ref_id;

            /**
             *  To get all the outputs
            */

            dd($refund->output);
        }
        else 
        {
            return $refund->message;
        }
    }

```
### Transaction Query
Also you can query for your Transaction based on the Transaction ID you provided.

```php 

    public function get_transaction_status($trxID)
    {
        $query = SSLCommerz::query_transaction($trxID);
	
        if($query->status)
        {
            dd($query->output);
        }
        else 
        {
            $query->message;
        }
    }

```

## Available Methods

###  <kbd>required</kbd> ``amount($amount)``

Description: Set the amount of payment

Usage: ``$sslc->amount(50)``

### <kbd>required</kbd> ``trxid($trxid = null)``

Description: Set the Transaction ID. If ``null`` passed, php ``uniqid()`` will be used to generate the TrxID

Usage: ``$sslc->trxid(mt_rand(10000000,999999999))``

### <kbd>required</kbd> ``product($name [,$category])`` 

Description: Set the Product Name (required) and Category (optional)

Usage: ``$sslc->product($product->name, $product->category)``

### <kbd>required</kbd> ``customer($name, $email [,$phone, $address, $city, $state, $postal, $country, $fax])`` 

Description: Set the Customer Name and Email (required), Phone,Address,City,State,Postal Code, Country, FAX Code (optional)

Usage: ``$sslc->customer($user->name, $user->email, $user->phone)``

### <kbd>optional</kbd> ``setUrl($url_array[])`` 

Description: To Manually set the success,failure,cancel and ipn URL not using from .env one

Usage: ``$sslc->setUrl([route('custome.success'), route('custom.failure'), .. ])``

### <kbd>optional</kbd> ``setCurrency($currency)`` 

Description: To Manually set the currency not using from .env one

Usage: ``$sslc->setCurrency('USD')``

### <kbd>optional</kbd> ``setBin($bin)`` 

Description: You can provide the BIN of card to allow the transaction must be completed by this BIN. You can declare by coma ',' separate of these BIN. Example: 371598,371599,376947,376948,376949

Usage: ``$sslc->setBin('371598,371599,376947')``

### <kbd>optional</kbd> ``enableEMI($installment, $max_installment, bool $restrict_emi_only = false)`` 

Description: This method enables EMI payment. 

**installment** = Customer selects from your Site, So no instalment option will be displayed at gateway page

**max_installment** = Max instalment Option, Here customer will get 3,6, 9 instalment at gateway page

**restrict_emi_only** = Value is true/false, if value is true then only EMI transaction is possible, in payment page. No Mobile banking and internet banking channel will not display.

Usage: ``$sslc->enableEMI(5,12,false)``

### <kbd>optional</kbd> ``setShipping($product_number, $name, $address, $city [,$postal, $state, $country])`` 

Description: This method sets shipping details. Not required usually!

Usage: ``$sslc->setShipping(5,'productname','24/7 Beijing Street','Dhaka',1234)``

### <kbd>optional</kbd> ``setAirlineTicketProfile($flight_type, $hours_till_departure, $pnr, $journey_from_to, $third_party_booking)`` 

Description: This method is Mandatory, if **product_profile** is *airline-tickets*! Not usually required! See [Official Documentation](https://developer.sslcommerz.com/doc/v4/) for this section.

Usage: ``$sslc->setAirlineTicketProfile('bus',3,1,'DHK-RAJ',null)``

### <kbd>optional</kbd> ``setTravelVerticalProfile($hotel_name, $length_of_stay, $check_in_time, $hotel_city)`` 

Description: This method is Mandatory, if **product_profile** is *travel-vertical*! Not usually required! See [Official Documentation](https://developer.sslcommerz.com/doc/v4/) for this section.

Usage: ``$sslc->setTravelVerticalProfile('Dalas',3,'12:00pm',Rajshahi)``

### <kbd>optional</kbd> ``setTelecomVerticleProfile($product_type, $topup_number, $country_topup)`` 

Description: This method is Mandatory, if **product_profile** is *telecom-vertical*! Not usually required! See [Official Documentation](https://developer.sslcommerz.com/doc/v4/) for this section.

Usage: ``$sslc->setTelecomVerticleProfile('Flexiload',0170000000,'BD')``

### <kbd>optional</kbd> ``setCarts($cart, $product_amount, $vat, $discount_amount, $convenience_fee)`` 

Description: This method is not usually used! See [Official Documentation](https://developer.sslcommerz.com/doc/v4/) for this section.

Usage: ``$sslc->setCarts($cart_json,5,'3%','20%','500')``

### <kbd>optional</kbd> ``setExtras($extra1, $extra2, $extra3, $extra4)`` 

Description: This method is used to pass to the success/failure response as extra parameter, if it is needed. Not mandatory! See [Official Documentation](https://developer.sslcommerz.com/doc/v4/) for this section.

Usage: ``$sslc->setExtras($my_token)``

###  <kbd>required</kbd> ``make_payment($checkout = false)``

Description: Make the payment. 1. For hosted mode (default), pass nothing/false. 2. For checkout mode, pass the first param ``true``, and it will return JSON

Usage: ``$sslc->make_payment()``

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
