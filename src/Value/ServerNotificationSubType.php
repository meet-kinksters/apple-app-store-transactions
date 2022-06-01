<?php

declare(strict_types=1);

namespace Kinksters\Apple\Value;

/**
 * Server notification subtypes.
 * 
 * Enum names are prefixed by the primary notification type.
 *
 * @see https://developer.apple.com/documentation/appstoreservernotifications/subtype
 */
enum ServerNotificationSubType: string {

  case SUBSCRIBED_INITIAL_BUY = 'INITIAL_BUY';

  case SUBSCRIBED_RESUBSCRIBE = 'RESUBSCRIBE';

  case DID_CHANGE_RENEWAL_PREF_DOWNGRADE = 'DOWNGRADE';

  case DID_CHANGE_RENEWAL_PREF_UPGRADE = 'UPGRADE';

  case DID_CHANGE_RENEWAL_STATUS_AUTO_RENEW_DISABLED = 'AUTO_RENEW_DISABLED';

  case DID_CHANGE_RENEWAL_STATUS_AUTO_RENEW_ENABLED = 'AUTO_RENEW_ENABLED';

  case EXPIRED_VOLUNTARY = 'VOLUNTARY';

  case EXPIRED_BILLING_RETRY = 'BILLING_RETRY';

  case EXPIRED_PRICE_INCREASE = 'PRICE_INCREASE';

  case DID_FAIL_TO_RENEW_GRACE_PERIOD = 'GRACE_PERIOD';

  case DID_RENEW_BILLING_RECOVERY = 'BILLING_RECOVERY';

  case PRICE_INCREASE_PENDING = 'PENDING';

  case PRICE_INCREASE_ACCEPTED = 'ACCEPTED';

}
