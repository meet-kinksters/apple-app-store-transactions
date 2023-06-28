<?php

declare(strict_types=1);

namespace Kinksters\Apple\Value;

use EventSauce\ObjectHydrator\DefinitionProvider;
use EventSauce\ObjectHydrator\KeyFormatterWithoutConversion;
use EventSauce\ObjectHydrator\ObjectHydrator;
use EventSauce\ObjectHydrator\ObjectMapperUsingReflection;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use ReceiptValidator\iTunes\PurchaseItem;

/**
 * Value object for server notifications.
 */
final class ServerNotification {

  /**
   * Constructor.
   *
   * @param \Kinksters\Apple\Value\ServerNotificationType $type
   * @param \ReceiptValidator\iTunes\PurchaseItem $purchaseItem
   * @param \Kinksters\Apple\Value\RenewalInfo|null $renewalInfo
   * @param \Kinksters\Apple\Value\ServerNotificationSubtype|null $subtype
   */
  public function __construct(
    public readonly ServerNotificationType $type,
    public readonly PurchaseItem $purchaseItem,
    public readonly ?RenewalInfo $renewalInfo = NULL,
    public readonly ?ServerNotificationSubtype $subtype = NULL,
  ) {}

  /**
   * Create an instance from a notification payload.
   *
   * @param array $notification
   * @param \Firebase\JWT\Key $key
   *
   * @return static
   */
  public static function fromNotification(array $notification, Key $key): static {
    return new static(
      ServerNotificationType::from($notification['notificationType']),
      static::purchaseItemFromServerNotification($notification, $key),
      !empty($notification['data']->signedRenewalInfo)
        ? static::renewalInfoFromServerNotification($notification, $key)
        : NULL,
      ServerNotificationSubType::tryFrom($notification['subtype'] ?? '')
    );
  }

  /**
   * Create a purchase item value object from the payload.
   *
   * @param array $notification
   * @param \Firebase\JWT\Key $key
   *
   * @return \ReceiptValidator\iTunes\PurchaseItem
   */
  protected static function purchaseItemFromServerNotification(array $notification, Key $key): PurchaseItem {
    assert(!empty($notification['data']->signedTransactionInfo));
    $original = (array) JWT::decode(urldecode($notification['data']->signedTransactionInfo), $key);
    return new PurchaseItem(array_combine(
      array_map(fn($v) => static::camelToSnakeCase($v), array_keys($original)),
      array_values($original)
    ));
  }

  /**
   * Create a renewal info value object from a notification payload.
   *
   * @param array $notification
   * @param \Firebase\JWT\Key $key
   *
   * @return \Kinksters\Apple\Value\RenewalInfo
   */
  protected static function renewalInfoFromServerNotification(array $notification, Key $key): RenewalInfo {
    assert(!empty($notification['data']->signedRenewalInfo));
    $hydrator = new ObjectMapperUsingReflection(new DefinitionProvider(
      keyFormatter: new KeyFormatterWithoutConversion(),
    ));
    return $hydrator->hydrateObject(
      RenewalInfo::class,
      (array) JWT::decode(urldecode($notification['data']->signedRenewalInfo), $key)
    );
  }

  /**
   * Convert CamelCase to snake_case.
   *
   * The parameter casing is different for notifications vs. receipts.
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
