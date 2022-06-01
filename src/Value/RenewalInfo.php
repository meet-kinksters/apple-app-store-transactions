<?php

declare(strict_types=1);

namespace Kinksters\Apple\Value;

/**
 * Renewal info value object.
 *
 * @see https://developer.apple.com/documentation/appstoreservernotifications/jwsrenewalinfodecodedpayload
 */
final class RenewalInfo {

  /**
   * Constructor.
   *
   * @param string $autoRenewProductId
   * @param string $environment
   * @param int $expirationIntent
   * @param bool $isInBillingRetryPeriod
   * @param string $originalTransactionId
   * @param string $productId
   * @param int $signedDate
   * @param int $autoRenewStatus
   * @param int|null $gracePeriodExpiresDate
   * @param string|null $offerIdentifier
   * @param int|null $offerType
   * @param int|null $priceIncreaseStatus
   */
  public function __construct(
    public readonly string $autoRenewProductId,
    public readonly string $environment,
    public readonly int $expirationIntent,
    public readonly bool $isInBillingRetryPeriod,
    public readonly string $originalTransactionId,
    public readonly string $productId,
    public readonly int $signedDate,
    public readonly int $autoRenewStatus,
    public readonly ?int $gracePeriodExpiresDate = NULL,
    public readonly ?string $offerIdentifier = NULL,
    public readonly ?int $offerType = NULL,
    public readonly ?int $priceIncreaseStatus = NULL,
  ) {}

}
