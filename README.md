# Translation bundle

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

## Enjoy

You are done. Now edit the translations as you like
