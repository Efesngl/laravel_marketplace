<?php

namespace App\Helpers;

use App\Models\Deal;
use App\Models\User;
use Illuminate\Http\Request;

class Iyzico
{
    private $options;
    public function __construct()
    {
        $this->options = new \Iyzipay\Options();
        $this->options->setApiKey(env('IYZICO_API_KEY'));
        $this->options->setSecretKey(env('IYZICO_SECRET'));
        $this->options->setBaseUrl("https://sandbox-api.iyzipay.com");
    }
    public function createSubMerchant(User $user)
    {
        $request = new \Iyzipay\Request\CreateSubMerchantRequest();
        $request->setLocale(\Iyzipay\Model\Locale::TR);
        $request->setSubMerchantExternalId($user->id);
        $request->setSubMerchantType(\Iyzipay\Model\SubMerchantType::PERSONAL);
        $request->setAddress($user->address);
        $request->setContactName(explode(" ", $user->name)[0]);
        $request->setContactSurname(explode(" ", $user->name)[1]);
        $request->setEmail($user->email);
        $request->setGsmNumber("+90" . $user->phone_number);
        $request->setName($user->name . "'s market");
        $request->setIban($user->iban);
        $request->setIdentityNumber($user->tc_no);
        $request->setCurrency(\Iyzipay\Model\Currency::TL);

        return \Iyzipay\Model\SubMerchant::create($request, $this->options);
    }
    public function updateSubMerchant(User $user)
    {
        $request = new \Iyzipay\Request\UpdateSubMerchantRequest();
        $request->setLocale(\Iyzipay\Model\Locale::TR);
        $request->setSubMerchantKey($user->sub_merchant_key);
        $request->setIban($user->iban);
        $request->setAddress($user->address);
        $request->setContactName(explode(" ", $user->name)[0]);
        $request->setContactSurname(explode(" ", $user->name)[1]);
        $request->setEmail($user->email);
        $request->setGsmNumber("+90{$user->phone_number}");
        $request->setName($user->name . "'s market");
        $request->setIdentityNumber($user->tc_no);
        $request->setCurrency(\Iyzipay\Model\Currency::TL);

        # make request
        return \Iyzipay\Model\SubMerchant::update($request, $this->options);
    }
    public function initCheckoutForm(Request $req,User $user,Deal $deal)
    {

        # create request class
        $request = new \Iyzipay\Request\CreateCheckoutFormInitializeRequest();
        $request->setLocale(\Iyzipay\Model\Locale::TR);
        $request->setPrice($deal->price);
        $request->setPaidPrice($deal->price*1.20);
        $request->setCurrency(\Iyzipay\Model\Currency::TL);
        $request->setBasketId("B67832");
        $request->setPaymentGroup(\Iyzipay\Model\PaymentGroup::PRODUCT);
        $request->setCallbackUrl("https://www.merchant.com/callback");
        $request->setEnabledInstallments(array(2, 3, 6, 9));

        $buyer = new \Iyzipay\Model\Buyer();
        $buyer->setId($user->id);
        $buyer->setName(explode(" ",$user->name)[0]);
        $buyer->setSurname(explode(" ",$user->name)[1]);
        $buyer->setGsmNumber("+90{$user->phone_number}");
        $buyer->setEmail($user->email);
        $buyer->setIdentityNumber($user->tcno);
        $buyer->setRegistrationAddress($user->address);
        $buyer->setIp($req->ip());
        $buyer->setCity("Istanbul");
        $buyer->setCountry("Turkey");
        $buyer->setZipCode("34732");
        $request->setBuyer($buyer);

        $shippingAddress = new \Iyzipay\Model\Address();
        $shippingAddress->setContactName("Jane Doe");
        $shippingAddress->setCity("Istanbul");
        $shippingAddress->setCountry("Turkey");
        $shippingAddress->setAddress("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
        $shippingAddress->setZipCode("34742");
        $request->setShippingAddress($shippingAddress);

        $billingAddress = new \Iyzipay\Model\Address();
        $billingAddress->setContactName("Jane Doe");
        $billingAddress->setCity("Istanbul");
        $billingAddress->setCountry("Turkey");
        $billingAddress->setAddress("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
        $billingAddress->setZipCode("34742");
        $request->setBillingAddress($billingAddress);

        $basketItems = array();
        $firstBasketItem = new \Iyzipay\Model\BasketItem();
        $firstBasketItem->setId($deal->id);
        $firstBasketItem->setName($deal->title);
        $firstBasketItem->setCategory1("Collectibles");
        $firstBasketItem->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
        $firstBasketItem->setPrice($deal->price);
        $firstBasketItem->setSubMerchantKey("d6KWJhnIOOptfiMuZRjoQcyHLzA=");
        $firstBasketItem->setSubMerchantPrice($deal->price);
        $basketItems[0] = $firstBasketItem;

        $request->setBasketItems($basketItems);

        # make request
        $checkoutFormInitialize = \Iyzipay\Model\CheckoutFormInitialize::create($request, $this->options);

        # print result
        return $checkoutFormInitialize;
    }
}