<?php

declare(strict_types=1);

namespace Kinksters\Apple\Value;

/**
 * Enum of server notification types.
 *
 * @see https://developer.apple.com/documentation/appstoreservernotifications/notificationtype
 */
enum ServerNotificationType: string {

  case SUBSCRIPTION_RENEWAL = 'DID_RENEW';

  case SUBSCRIPTION_NEW = 'SUBSCRIBED';

  case SUBSCRIPTION_EXPIRE = 'EXPIRED';

  case REFUND = 'REFUND';

  case SUBSCRIPTION_RENEWAL_FAILED = 'DID_FAIL_TO_RENEW';

  case CONSUMPTION_REQUEST = 'CONSUMPTION_REQUEST';

  case SUBSCRIPTION_CHANGED_RENEWAL_PREFERENCE = 'DID_CHANGE_RENEWAL_PREF';

  case SUBSCRIPTION_CHANGED_RENEWAL_STATUS = 'DID_CHANGE_RENEWAL_STATUS';

  case SUBSCRIPTION_GRACE_PERIOD_EXPIRED = 'GRACE_PERIOD_EXPIRED';

  case SUBSCRIPTION_OFFER_REDEEMED = 'OFFER_REDEEMED';

  case SUBSCRIPTION_PRICE_INCREASE = 'PRICE_INCREASE';

  case REFUND_DECLINED = 'REFUND_DECLINED';

  case SUBSCRIPTION_RENEWAL_EXTENDED = 'RENEWAL_EXTENDED';

  case FAMILY_SHARING_REVOKE = 'REVOKE';

}