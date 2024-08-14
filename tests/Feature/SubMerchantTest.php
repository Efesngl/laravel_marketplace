<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Helpers\Iyzico;

class SubMerchantTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_create_submerchant(): void
    {
        $user = User::find(2);
        print_r($user);
        // $iyzico=new Iyzico();
        // $iyzico::createSubMerchant($user);
    }
}
