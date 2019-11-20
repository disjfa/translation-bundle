# Translation bundle

[![Check on packagist][packagist-badge]][packagist]
[![MIT License][license-badge]][LICENSE]

[![Watch on GitHub][github-watch-badge]][github-watch]
[![Star on GitHub][github-star-badge]][github-star]
[![Tweet][twitter-badge]][twitter]

Hello, and welcome to my Translation Bundle. This is a bundle for symfony and it is using a doctrine layer to append on the existing translations in your system.

## What does this bundle solve

This bundle saves changed translations on a deployed website to the database. This is to test labels or if users would like to "manage" their own.

The bundle extends the cache and updates the translations from a [Symfony translation](https://symfony.com/doc/current/translation.html) and updates them from the database.

## Why do i not want to use this

If you are developing, and just want to fix and save translations. Use the [Symfony translation](https://symfony.com/doc/current/translation.html) 
or maybe extent this using the [Php translations](http://php-translation.readthedocs.io/en/latest/) bundle [here](https://github.com/php-translation/symfony-bundle).
Here you can set up all your translations as a base layer and configure them.

## Wait! Why do i use this bundle then?

After a deplay poeple like to use and abuse the labels in the system. Just wanting something else. This is the sweet spot. Just install and go. Let's see where this goes. Just as an extension.

## Cool! Lets go

Just install it using composer, to add this to your symfony project
```bash
composer req disjfa/translation-bundle
```

And set up the routes in `config/routes/disjfa_translation.yaml` in symfony4 or arr them to your routes:
```yaml
disjfa_translation:
    resource: '@DisjfaTranslationBundle/Controller/'
    type:     annotation
```

## Installed

Now you can go to http://localhost/translation to edit the routes.

Also you can prefix the routes to move them to an admin route
```yaml
disjfa_translation:
    resource: '@DisjfaTranslationBundle/Controller/'
    type:     annotation
    prefix:   /admin
```

## Optional
Setup the knp paginator service and set up the bootstrap theme
```yaml
knp_paginator:
    template:
        pagination: '@KnpPaginator/Pagination/twitter_bootstrap_v4_pagination.html.twig'     # sliding pagination controls template
```

## Enjoy

You are done. Now edit the translations as you like

[packagist-badge]: https://img.shields.io/packagist/v/disjfa/translation-bundle
[packagist]: https://packagist.org/packages/disjfa/translation-bundle
[license]: https://github.com/disjfa/translation-bundle/blob/master/LICENSE
[license-badge]: https://img.shields.io/github/license/disjfa/translation-bundle.svg
[github-watch-badge]: https://img.shields.io/github/watchers/disjfa/translation-bundle.svg?style=social
[github-watch]: https://github.com/disjfa/translation-bundle/watchers
[github-star-badge]: https://img.shields.io/github/stars/disjfa/translation-bundle.svg?style=social
[github-star]: https://github.com/disjfa/translation-bundle/stargazers
[twitter-badge]: https://img.shields.io/twitter/url/https/github.com/disjfa/translation-bundle.svg?style=social
[twitter]: https://twitter.com/intent/tweet?text=Check%20out%20translation-bundle!%20-%20Cool%mail%20translations%20for%20symfony!%20Thanks%20@disjfa%20https://github.com/disjfa/translation-bundle%20%F0%9F%A4%97
