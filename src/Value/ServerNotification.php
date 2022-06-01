<?php

declare(strict_types=1);

namespace Kinksters\Apple\Value;

use EventSauce\ObjectHydrator\ObjectHydrator;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use ReceiptValidator\iTunes\PurchaseItem;

final class ServerNotification {

  public function __construct(
    public readonly ServerNotificationType $type,
    public readonly PurchaseItem $purchaseItem,
    public readonly ?RenewalInfo $renewalInfo = NULL,
  ) {}

  public static function fromNotification(array $notification, Key $key): static {
    return new static(
      ServerNotificationType::from($notification['notificationType']),
      static::purchaseItemFromServerNotification($notification, $key),
      !empty($notification['data']->signedRenewalInfo)
        ? static::renewalInfoFromServerNotification($notification, $key)
        : NULL
    );
  }

  protected static function purchaseItemFromServerNotification(array $notification, Key $key): PurchaseItem {
    assert(!empty($notification['data']->signedTransactionInfo));
    $original = (array) JWT::decode(urldecode($notification['data']->signedTransactionInfo), $key);
    return new PurchaseItem(array_combine(
      array_map(fn($v) => static::camelToSnakeCase($v), array_keys($original)),
      array_values($original)
    ));
  }

  protected static function renewalInfoFromServerNotification(array $notification, Key $key): RenewalInfo {
    assert(!empty($notification['data']->signedRenewalInfo));
    $hydrator = new ObjectHydrator();
    return $hydrator->hydrateObject(
      RenewalInfo::class,
      (array) JWT::decode(urldecode($notification['data']->signedRenewalInfo), $key)
    );
  }

  /**
   * Convert CamelCase to snake_case.
   *
   * @see https://stackoverflow.com/a/40514305/4447064
   *
   * @param $string
   *   CamelCase string.
   *
   * @return string
   *   The snake_case equivalent.
   */
  protected static function camelToSnakeCase($string) {
    return strtolower(preg_replace('/(?<=\d)(?=[A-Za-z])|(?<=[A-Za-z])(?=\d)|(?<=[a-z])(?=[A-Z])/', '_', $string));
  }

}
