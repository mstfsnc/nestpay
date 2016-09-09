# Omnipay: NestPay 3D_Pay
[thephpleague/omnipay](https://github.com/thephpleague/omnipay) ödeme altyapsı için hazırlanmış NestPay kütüphanesi.

### İçindeki metodlar:
 * **Purchase** (*Auth*: Satış)
 * **Authorize** (*PreAuth*: Ön Otorizasyon)
 * **Capture** (*PostAuth*: Otorizasyon Kapatma)
 * **Void** (*Void*: İptal)
 * **Refund** (*Credit*: İade)

### NestPay (EST) alt yapsını kullanan bankalar:
 * İş Bankası
 * Akbank
 * Finansbank
 * Halkbank
 * Anadolubank
 * ..
 
## Kurulum

	composer require mstfsnc/nestpay
## Örnekler
```php
	<?php
	
    require __DIR__ . '/vendor/autoload.php';

    use Omnipay\Omnipay;

    $gateway = Omnipay::create('Nestpay');
    $gateway->setBank('isbank');
    $gateway->setClientId('700655000200');
    $gateway->setStoreKey('TRPS1234');
    $gateway->setFirmName('Test Firma');

    $card = [
        'number'        => '5105105105105100',
        'expiryMonth'   => '12',
        'expiryYear'    => '16',
        'cvv'           => '000',
        'email'         => 'card@card.com',
        'firstname'     => 'Test',
        'lastname'      => 'Card',
    ];

    try {
        
        $options = [
            'amount'        => 19.80,
            'currency'      => 949, //TRY
            'installment'   => 1,
            'orderid'       => 'S-193354',
            'returnUrl'     => 'http://localhost:8000/return.php',
            'cancelUrl'     => 'http://localhost:8000/fail.php',
            'card'          => $card,
        ];
    
        // Auth (Satış)
        $response = $gateway->purchase($options)->send();
        
        // PreAuth (Ön Otorizasyon)
        $response = $gateway->authorize($options)->send();

        if ($response->isRedirect()) {
            // doğrulama için sağlayıcının 3d kapısına yönlendiriyor
            $response->redirect();
        } else {
            // işlem gerçekleşmedi
            echo $response->getMessage();
        }
        
    } catch (\Exception $e) {
        echo $e->getMessage();
    }
```

```php
	<?php
	
	require __DIR__ . '/vendor/autoload.php';
	
	use Omnipay\Omnipay;
	
	$gateway = Omnipay::create('Nestpay');
	$gateway->setBank('isbank');
	$gateway->setClientId('700655000201');
	$gateway->setUsername('ISBANK');
	$gateway->setPassword('ISBANK07');
	
	try {
	
		$options = ['orderid' => 'S-193354'];
		
		// PostAuth (Otorizasyon Kapama)
		$response = $gateway->capture($options)->send();
		
		// Void (İptal)
		$response = $gateway->void($options)->send();
		
		// Refund (İade)
		$response = $gateway->refund($options)->send();
		
		if ($response->isSuccessful()) {
			// işlem başarılı
		} else {
			// işlem gerçkelşemedi
			echo $response->getMessage();
		}
	
	} catch (\Exception $e) {
		echo $e->getMessage();
	}
```

## Yardım

[GitHub issue tracker](https://github.com/mstfsnc/nestpay/issues)

## Diğer Omnipay Paketleri

 * NestPay (CC5) https://github.com/yasinkuyu/omnipay-nestpay
 * Postnet https://github.com/yasinkuyu/omnipay-posnet
 * Iyzico https://github.com/yasinkuyu/omnipay-iyzico
 * GVP (Granti Sanal Pos) https://github.com/yasinkuyu/omnipay-gvp
 * BKM Express https://github.com/yasinkuyu/omnipay-bkm