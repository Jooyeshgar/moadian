# Laravel Moadian API Driver

> NOTE: This package is currently under development and is not ready for production use.

This Laravel package provides a convenient way to interact with the API of the "Moadian system" (سامانه مودیان) offered by intamedia.ir. With this package, you can easily make requests to the Moadian API and handle the responses in your Laravel application.

## Requirements

This package requires Laravel 8 or higher. It has been tested with Laravel 8 and PHP 7.4, as well as with Laravel 10 and PHP 8.1.

## Installation

To install this package, simply run the following command:
```bash
composer require jooyeshgar/moadian
```
## Usage

To use this package, you will need to obtain a username and private key from intamedia.ir. Once you have your credentials, you can configure the package in your Laravel application's `.env` file:

```
MOADIAN_USERNAME=your-username-here
MOADIAN_PRIVATE_KEY_PATH=/path/to/private.key
```
You can then use the `Moadian` facade to interact with the Moadian API. Here are some examples:

```php
use Jooyeshgar\Moadian\Facades\Moadian;

// Get server info
$info = Moadian::getServerInfo();

// Get token
$info = Moadian::getToken();

// Get fiscal info
$fiscalInfo = Moadian::getFiscalInfo();

// Get economic code information
$info = Moadian::getEconomicCodeInformation('10840096498');

// Inquiry by reference numbers
$info = Moadian::inquiryByReferenceNumbers(["a45aa663-6888-4025-a89d-86fc789672a0"]);
```

For more information on how to use this package, please refer to the official documentation.

## Contributing

If you find a bug or would like to contribute to this package, please feel free to [submit an issue](https://github.com/Jooyeshgar/moadian/issues) or [create a pull request](https://github.com/Jooyeshgar/moadian/pulls).

## License

This package is open source software licensed under the [GPL-3.0 license](https://opensource.org/licenses/GPL-3.0).