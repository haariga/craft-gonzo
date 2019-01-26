# Gonzo — Pattern Library


![Screenshot](resources/img/plugin-logo.png)

```
*** BETA **********

!IMPORTANT NOTE!
This plugin is currently under development and requires a special structure in your templates folder to be used.
Please scroll to the Structure example to learn more.
If you have any recommendations on how to improve it please create a ticket on GitHub.

Thank you very much
David & Martin

*******************
```

## Demo

You can this plugin in action here:
https://craft3.baukasten.io/patternlib#/

## Description

Gonzo is the Pattern Library with less effort. You've just created config files to bring your components in the library. 
It's quite simple. You need no third party tool to have a pattern library. Just write your code as usual but start not
with dummy hard written content in your templates. You also need entries in the backend (just some images) to fill your components.
Each component have an config.php file and here is all the magic. It's a huge advantage to use gonzo. 

The developer can create components decoupled from templates or whole pages. Focus on the component and build all variants 
for your specific component. When you are done set the status to **review** or something else and give it back to the designer to
get an approval. The whole team can see the component status and it's clear for all what's done and what's on development. 

A second huge benefit for the team is that you can see all you components on one place. What's not in the library does not exist.
It's really clear someone can check which buttons are currently on the project. 

Third benefit is you can discuss about specific components with the client without lose the focus. 

It's a living library and if your project grows your library will grow too!

---

**Table of contents**

* [Requirements](#requirements)
* [Installation](#installation)
* [Configuration](#configuration)
* [Screenshots](#screenshots)
* [Folder Structure](#structure)
* [Example](#example)
* [Pages](#pages)
* [Roadmap](#roadmap)

---


## Requirements
This plugin requires Craft CMS 3.0.0 or later.

## Installation
### Install via composer

```bash
composer require haariga/craft-gonzo
```

### Install via Admin Control Panel
Go to the Plugin Store and search for: `Gonzo` and install it. 


## Configuration

### Plugin Config File
You must create a `craft-gonzo.php` file in your config folder. 
Here is a basic config file you can start with. In the `_examples` folder is a more complex one to create additional pages
and stuff like this.

```php
<?php
return [
	 // The folders that are visible within the library.
	 // Currently we can display just folder one level deep in your templates folder
    "compFolders" => [
        "_atoms",
        "_molecules",
        "_organisms",
        "_embeds",
        "_views"
    ],
    // The different buttons to resize the iFrame. 
    // It's up to you to motifie this sizes
    "mqButtons" => [
        "min" => "320px",
        "xs" => "400px",
        "s" => "600px",
        "m" => "800px",
        "l" => "1000px",
        "max" => "1440px",
        "fluid" => "100vw"
    ],
    // The different component statusses for your components
    // Create your own or start with the following
    "compStatus" => [
        0 => ["name" => "wip", "color" => "#FF9800"],
        1 => ["name" => "review", "color" => "#369BF4"],
        2 => ["name" => "done", "color" => "#4CAF50"],
        3 => ["name" => "discarded", "color" => "#F44336"],
    ],
    // You can configure custom pages for this plugin
    "pages" => [
	    'typography' => [
		    'label' => 'Typography',
		    'options' => [...]
			],
			'colors' => [
				'label' => 'Colors',
				'options' => [...],
    ],
];
```

### Component Config File
This are the minimum settings that we can display at the moment. A more complex sample is in the `_examples` folder.

```php
<?php
// Describe your component
$componentMeta = [
    'title' => 'sampleComponent',
    'status' => 'wip',
    'visible' => true,
    'type' => 'atom',
    'path' => '_atoms/sampleComponent/',
    'description' => 'sampleComponent Description'
];

$defaultVariant = [
    'title' => 'sampleComponent Variant Title',
    'status' => '', // if empty the global status is used
    'description' => 'sampleComponent Variant Description'
];

return [
    'meta' => array_merge($componentMeta, []),
];
```



## Screenshots

### Components

#### Headline

![Screenshot](resources/img/craft-gonzo-screenshot-01.png)

#### Contact Form

![Screenshot](resources/img/craft-gonzo-screenshot-02.png)

#### Image Grid

![Screenshot](resources/img/craft-gonzo-screenshot-03.png)

### Typography

#### Headings

![Screenshot](resources/img/craft-gonzo-screenshot-typo-01.png)

#### Glyphs

![Screenshot](resources/img/craft-gonzo-screenshot-typo-02.png)

### Colors

#### Branding Colors

![Screenshot](resources/img/craft-gonzo-screenshot-colors-01.png)

#### Grayscales

![Screenshot](resources/img/craft-gonzo-screenshot-colors-02.png)


## Structure
The plugin currently works best with a maximum of 2 levels
```
├── _atoms
│   ├── button
│   │   ├── _button.js
│   │   ├── _button.scss
│   │   ├── _button.{twig|html}
│   │   └── config.php
│   ├── headline
│   │   ├── _headline.js
│   │   ├── _headline.scss
│   │   ├── _headline.{twig|html}
│   │   └── config.php
│   ├── image
│   │   ├── _image.js
│   │   ├── _image.scss
│   │   ├── _image.{twig|html}
│   │   └── config.php
├── _molecules
│   ├── card
│   │   ├── _script.js
│   │   ├── _style.scss
│   │   ├── _template.{twig|html}
│   │   └── config.php
├── _organisms
│   ├── accordion
│   │   ├── _script.js
│   │   ├── _style.scss
│   │   ├── _template.{twig|html}
│   │   └── config.php
│   ├── cards
│   │   ├── _script.js
│   │   ├── _style.scss
│   │   ├── _template.{twig|html}
│   │   └── config.php
```

You can have other folders and files in your templates folder but this is a tested and used structure.
You should set the `"compFolders"` setting to something like this:
```
"compFolders" => [
	"_atoms",
	"_molecules",
	"_organisms",
]
```
All filenames except the config.php don't really matter, the plugin searches for `*.twig`, `*.scss` and `*.js` files.

## Example
### Headline Component

Here is a real world example. It's a simple headlone component. In this case, it's an `atom`.
Overall we have four files. `_template.html` is our Template file with all the template logic inside.
`config.php` is the core file to render the module in the pattern lib. Here is the dummy content to fill
the component. Here are also the different variants to define. In this case **H1**, **H2** etc. Third file is the `_style.scss` file 
where we can style our component. Last file ist the `_script.js` file when the component needs some Javascript code.  


#### _template.html

```twig
{# @var craft \craft\web\twig\variables\CraftVariable #}
{# @var entry \craft\elements\Entry #}
{#
  a-headline
  ------------------------------------------------------------
#}

{# -- Set Defaults -- #}
{% set defaults = {
  cn: 'a-headline',
  modifiers: [],
  customClasses: [],
  data: {},
  js: null,
  text: null,
  size: 'h2'
} %}

{# -- Merge Default with Options -- #}
{% set opt = opt is defined ? defaults|merge(opt) : defaults %}

{# -- Modul -- #}
{% if opt.text %}
  <{{ opt.size }} class="{{ opt.cn }}
              {% for modifier in opt.modifiers %}
                {{ modifier | length ? '  ' ~ opt.cn ~ '--' ~ modifier }}
              {% endfor %}
              {% for customClass in opt.customClasses %}
                {{ customClass | length ? '  ' ~ customClass }}
              {% endfor %}  {{ opt.js ? opt.cn|replace({ 'a-' : 'js-' }) : '' }}"
              {% for key, value in opt.data %}
                {{ 'data-' ~ key ~ '=' ~ value }}
              {% endfor %}>
    {{ opt.text }}
  </{{ opt.size }}>
{% endif %}

```

#### config.php

```php
<?php
// Describe your component
$componentMeta = [
    'title' => 'Headline',
    'status' => 'done',
    'visible' => true,
    'type' => 'atom',
    'path' => '_atoms/headline/',
    'description' => 'This area the global / default Headline styles.'
];

// That's your default Variant. When you need just a single
// Variant you can describe it all here.
$defaultVariant = [
    'title' => 'Headline H1',
    'status' => '',
    'description' => 'This is a H1 Headline.',
    'cn' => 'a-headline',
    'modifiers' => [],
    'customClasses' => [],
    'data' => [],
    'js' => null,
    'waypoint' => null,
    'waypointAni' => null,
    'text' => 'The quick brown fox jumps over the lazy dog.',
    'size' => 'h1'
];

// When you need more as one variant this part is your friend.
// You can add endless variants.
return [
    'meta' => array_merge($componentMeta, []),
    'variants' => [
        'headline' => array_merge($defaultVariant, []),
        'headline--h2' => array_merge($defaultVariant, [
            'title' => 'Headline H2',
            'description' => 'This is a H2 Headline.',
            'size' => 'h2',
        ]),
        'headline--h3' => array_merge($defaultVariant, [
            'title' => 'Headline H3',
            'description' => 'This is a H3 Headline.',
            'size' => 'h3',
        ]),
        'headline--h4' => array_merge($defaultVariant, [
            'title' => 'Headline H4',
            'description' => 'This is a H4 Headline.',
            'size' => 'h4',
        ]),
        'headline--h5' => array_merge($defaultVariant, [
            'title' => 'Headline H5',
            'description' => 'This is a H5 Headline.',
            'size' => 'h5',
        ]),
        'headline--h6' => array_merge($defaultVariant, [
            'title' => 'Headline H6',
            'description' => 'This is a H6 Headline.',
            'size' => 'h6',
        ]),
    ]
];

```


#### _style.scss

```scss

/*
 |--------------------------------------------------------------------------
 |  a-headline
 |--------------------------------------------------------------------------
 */

// Modul
.a-headline {
  $root: &;
  width: 100%;

  + .a-subline {
    margin-top: s(2);
  }
}

// Modul Modifiers Example
.a-headline--modifier {
  .a-headline__block {
    // Styles here
  }
}
```

#### _script.js

```js
/**
 * headline
 */

const headline = {
    cfg:  {
        name: `headline`
    },

    log(msg) {
        console.log(msg)
    },

    init() {
        this.log(`Init: ${this.cfg.name}`)
    }
}

export default headline


```

## Pages
You can create custom pages for example a color page where you can show Colors used on the site.

To create a custom page just add it to the `pages` option and create a template in `patternlib/pages` the `key` should be the same as the filename for example `colors` -> `colors.{twig|html}`.
Every page should have a label key which is used for the navigation and an options key where you can define options you can use in this template.

## Roadmap
Some things to do, and ideas for potential features:

* Release it

Brought to you by [Martin Herweg](https://martinherweg.de) & [David Hellmann](https://davidhellmann.com)
