# Omnipay: NestPay 3D_Pay

[thephpleague/omnipay](https://github.com/thephpleague/omnipay) ödeme altyapısı için hazırlanmış NestPay kütüphanesi.

**Gereksinimler:** PHP 8.0+, league/omnipay ^3

## Desteklenen İşlemler

| Metod              | Tür      | Açıklama                           |
|--------------------|----------|------------------------------------|
| `purchase`         | Auth     | 3D_Pay satış                       |
| `completePurchase` | -        | 3D_Pay satış callback              |
| `authorize`        | PreAuth  | 3D_Pay ön otorizasyon              |
| `completeAuthorize`| -        | 3D_Pay ön otorizasyon callback     |
| `capture`          | PostAuth | Otorizasyon kapatma (CC5 API)      |
| `void`             | Void     | İptal (CC5 API)                    |
| `refund`           | Credit   | İade (CC5 API)                     |

## Desteklenen Bankalar

NestPay (EST) altyapısını kullanan bankalar:

| Banka         | `bank` Parametresi |
|---------------|--------------------|
| İş Bankası    | `isbank`           |
| Akbank        | `akbank`           |
| Finansbank    | `finansbank`       |
| Halkbank      | `halkbank`         |
| Anadolubank   | `anadolubank`      |
| Card Plus     | `cardplus`         |
| Test (Asseco) | `test`             |

## Kurulum

```bash
composer require mstfsnc/nestpay
```

## Kullanım

### Gateway Başlatma

```php
$gateway = Omnipay::create('Nestpay');
$gateway->setBank('akbank');
$gateway->setClientId('your-client-id');
$gateway->setUsername('your-username');
$gateway->setPassword('your-password');
$gateway->setStoreKey('your-store-key');
$gateway->setFirmName('Firma Adı');
$gateway->setBillName('Fatura Ad Soyad');      // Fatura müşteri adı
$gateway->setDeliveryName('Teslimat Ad Soyad'); // Teslimat müşteri adı
```

### 3D_Pay Satış (purchase)

```php
$response = $gateway->purchase([
    'amount'      => '100.00',
    'currency'    => 'TRY',
    'orderId'     => 'ORDER-001',
    'returnUrl'   => 'https://example.com/complete',
    'cancelUrl'   => 'https://example.com/cancel',
    'installment' => 0, // Taksit sayısı (0 = peşin)
    'card'        => [
        'number'      => '4355084355084358',
        'expiryMonth' => '12',
        'expiryYear'  => '2026',
        'cvv'         => '000',
    ],
])->send();

if ($response->isRedirect()) {
    $response->redirect(); // Bankaya POST yönlendirme
}
```

> Desteklenen kart markaları: **Visa**, **MasterCard**

### 3D_Pay Callback (completePurchase)

```php
$response = $gateway->completePurchase()->send();

if ($response->isSuccessful()) {
    $transactionId  = $response->getTransactionId();
    $reference      = $response->getTransactionReference();
    $orderId        = $response->getOrderId();
    $amount         = $response->getAmount();
    $currency       = $response->getCurrency();
} else {
    $error = $response->getMessage();
}
```

### Otorizasyon Kapatma (capture)

```php
$response = $gateway->capture([
    'orderId' => 'ORDER-001',
])->send();
```

### İptal (void)

```php
$response = $gateway->void([
    'orderId' => 'ORDER-001',
])->send();
```

### İade (refund)

```php
$response = $gateway->refund([
    'orderId' => 'ORDER-001',
])->send();
```

## v2.0 Değişiklikleri (PHP 8 Upgrade)

- **PHP 8.0** minimum versiyon gerekliliği
- `setBillName` / `getBillName` — parametre adı `Faturafirma` → `billName` olarak değişti (**breaking change**)
- `setDeliveryName` / `getDeliveryName` — parametre adı `tismi` → `deliveryName` olarak değişti (**breaking change**)
- Omnipay 3 / PSR-18 uyumlu HTTP client kullanımı (CC5 API)
- Tüm metotlara PHP 8 tip bildirimleri eklendi
- `omnipay/paypal` bağımlılığı kaldırıldı

## Yardım

[Issues](https://github.com/mstfsnc/nestpay/issues) sayfasından takip edebilirsiniz.

## Diğer Omnipay Paketleri

- NestPay (CC5) https://github.com/yasinkuyu/omnipay-nestpay
- Posnet https://github.com/yasinkuyu/omnipay-posnet
- Iyzico https://github.com/yasinkuyu/omnipay-iyzico
- GVP (Garanti Sanal Pos) https://github.com/yasinkuyu/omnipay-gvp
- BKM Express https://github.com/yasinkuyu/omnipay-bkm
