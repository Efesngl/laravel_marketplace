<?php

namespace App\Helpers;

use App\Models\User;

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
        $request->setName($user->name."'s market");
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
        $request->setName($user->name."'s market");
        $request->setIdentityNumber($user->tc_no);
        $request->setCurrency(\Iyzipay\Model\Currency::TL);

        # make request
        return \Iyzipay\Model\SubMerchant::update($request, $this->options);
    }
}