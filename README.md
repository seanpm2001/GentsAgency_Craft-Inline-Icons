![Craft Inline Icons](resources/img/plugin-logo.png)

A Twig helper for SVG icons

## Requirements

This module requires Craft CMS 3.0.0-RC1 or later.

## Installation

To install the module, follow these instructions.

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:

        composer require gentsagency/craft-inline-icons

3. Add contents of the `config/app.php` file to your `config/app.php` (or just copy it there if it does not exist). This ensures that your module will get loaded for each request. The file might look something like this:

        return [
            'modules' => [
                'inline-icons' => [
                    'class' => \gentsagency\inlineicons\InlineIcons::class,
                ],
            ],
            'bootstrap' => ['inline-icons'],
        ];


## Overview

The module is intended to work together with [@gentsagency/gulp-registry](https://github.com/gentsagency/gulp-registry); and more specifically the [icons task](https://github.com/gentsagency/gulp-registry/tree/master/tasks/icons).

It provides an easy `{{ icon('facebook') }}` Twig function to render icons in your Craft templates.

## Usage

> The examples below assume all front-end assets are built with [@gentsagency/gulp-registry](https://github.com/gentsagency/gulp-registry) to a path within the Craft `@webroot` path.

```twig
<ul class="socials">
    <li>
        <a href="https://facebook.com/gentsagency">
            {{ icon('facebook') }}
        </a>
    </li>
    <li>
        <a href="https://instagram.com/gentsagency">
            {{
                icon(
                    'instagram',
                    {
                        class: 'inline-icon',
                        inline: true,
                        alt: 'Follow us on Instagram'
                    }
                )
            }}
        </a>
    </li>
</ul>
```

### Available options

You can pass these options to the Twig function.

 - `class (default: 'icon')`: what class`s should be set on the SVG element
 - `inline (default: false)`: when set to true, the SVG will be parsed by the PHP and embedded in the code
 - `alt (default: icon name)`: use this to override the text read by screen readers; set to `false` to hide the icon from screen readers
 - `path (default: '/assets/icons/icons.svg')`: where the SVG icon spritesheet lives, gets prepended with `@webroot`
