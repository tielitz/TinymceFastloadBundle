# TinymceFastloadBundle

This bundle extends https://github.com/stfalcon/TinymceBundle so
https://github.com/stfalcon/TinymceBundle/blob/master/README.md must be readed first

## Installation

Add bundle as a dependency to the composer.json of your application

```php
    "require": {
        ...
        "gwinn/tinymce-fastload-bundle": "2.0.0"
        ...
    },
```
Add the custom repository
```php
    "repositories": [
        {
            "type": "package",
            "package": {
                "name": "tielitz/tinymce-fastload-bundle",
                "version": "2.0.0",
                "source": {
                    "url": "https://github.com/tielitz/TinymceFastloadBundle.git",
                    "type": "git",
                    "reference": "2.0.0"
                },
                "autoload": {
                    "psr-4": {
                        "Gwinn\\TinymceFastloadBundle\\": ""
                    }
                }
            }
        }
    ]
```

## Add bundle to your application kernel.

```php
// app/AppKernel.php
<?php
    // ...
    public function registerBundles()
    {
        $bundles = array(
            ...
            new Gwinn\TinymceFastloadBundle\GwinnTinymceFastloadBundle(),
        );
    }

```

## Configuration

### config.yml

Similar to tinymce-bundle, just add to assetic & stfalcon_tinymce & gwinn_tinymce_fastload section in config.yml

```yaml
assetic:
    ...
    bundles:
        - GwinnTinymceFastloadBundle
    ...

stfalcon_tinymce:
    ...
    tinymce_buttons:
        image_uploader:
        title: "Upload Image"
        image: "asset[bundles/gwinntinymcefastload/images/upload.png]"
    ...
    theme:
        simple:
            toolbar: "... | image_uploader | ..."
    ...

gwinn_tinymce_fastload:
    upload_path: '%tinymce.upload_path%'
    url_path:    '%tinymce.url_path%'
```

### parameters.yml

Add path to upload folder

```yaml
    tinymce.upload_path: '%kernel.root_dir%/../web/uploads/images/'
    tinymce.url_path:    '/uploads/images/
```

### routing.yml

Add bundle routes

```yaml
    tinymce_fastload_uploader:
        resource: "@GwinnTinymceFastloadBundle/Resources/config/routing.yml"
        prefix:   /
```


## Include in template

```twig
{% extends '::base.html.twig' %}

{% block body %}
    <form action="path('lab_basic_homepage')" method="post">
        <div>
            <textarea class="tinymce" name="simple-text"></textarea>
        </div>
    </form>

    {{ tinymce_init() }}
    {% include 'GwinnTinymceFastloadBundle:Uploader:tinymce_file_uploader.html.twig' %}

{% endblock %}

{% block stylesheets %}
    {% stylesheets filter='cssrewrite' output='css/compiled/style.css' 'bundles/gwinntinymcefastload/css/*' %}
        <link rel="stylesheet" href="{{ asset_url }}" />
    {% endstylesheets %}
{% endblock %}

```

## Copy resources to web folder

```bash
    php app/console assets:install web/
```
