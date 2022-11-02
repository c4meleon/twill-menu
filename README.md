# Twill menu

[![Latest Version on Packagist](https://img.shields.io/packagist/v/subcom/twill-menu.svg?style=flat-square)](https://packagist.org/packages/subcom/twill-menu)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/subcom/twill-menu/run-tests?label=tests)](https://github.com/:vendor_slug/subcom/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/subcom/twill-menu/Check%20&%20fix%20styling?label=code%20style)](https://github.com/:vendor_slug/subcom/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/subcom/twill-menu.svg?style=flat-square)](https://packagist.org/packages/subcom/twill-menu)

This a package build with laravel and twill to add menu module.

## Support us


## Installation

### Project setup

To install twill-menu package and all dependecies run the command below and follow the instructions:

```php
composer require subcom/twill-menu
```

### Config setup

1. Add this to config/twill.php inside block_editor:

```php
'directories' => [

            'source' => [

                'blocks' => [

                    'menu' => [

                        'title' => 'Menu',
                        'icon' => 'quote',
                        'component' => 'a17-block-menu',
                        'path' => base_path('vendor/subcom/twill-menu/src/Twill/Capsules/Menus/resources/views/admin/blocks'),
                        'source' => A17\Twill\Services\Blocks\Block::SOURCE_TWILL,
                    ],
                ],

            ],
        ],

        'repeaters' => [

            'menu-item' => [

                'title' => 'Aggiungi link',
                'trigger' => 'Aggiungi sottovoce',
                'component' => 'a17-block-menu-item',
                'path' => base_path('vendor/subcom/twill-menu/src/Twill/Capsules/Menus/resources/views/admin/blocks'),
                'source' => A17\Twill\Services\Blocks\Block::SOURCE_TWILL,
            ],

        ],
```
2. Run command:
```bash
php artisan optimize
```

3. Run command:
```bash
php artisan route:trans:clear
```
4. Run command:
```bash
php artisan vendor:publish --tag="twill-menu-config"
```
5. Publish files:
If you want to make changes use command bellow but you have to make changes in config to use twill default

```php
php artisan vendor:publish --tag="twill-menu-views"
php artisan vendor:publish --tag="twill-menu-controller"
```
## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://subcom.it) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [subcom](https://github.com/SubcomDev)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
