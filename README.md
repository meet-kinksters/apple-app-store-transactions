# PHP helpers for Apple App Store Transactions

Helpful tools for integrating with App Store transactions.

## Installation

```sh
composer require meet-kinksters/apple-app-store-transactions
```

## Features

This package is small and builds on existing foundational building blocks, e.g.
[`aporat/store-receipt-validator`](https://github.com/aporat/store-receipt-validator).

* Value objects for [server notifications](https://developer.apple.com/documentation/appstoreservernotifications/responding_to_app_store_server_notifications), including Enums for notification types and sub-types.
* In progress: Notification JWS payload parsing and validation. (This is particularly important as many online tutorials wrongly suggest simply parsing the certificate chain in the payload.)

&copy; Not Vanilla, LLC and contributors. MIT license.
