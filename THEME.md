# Lucid Theming Guide

## CSS variables

This should contains the following global definitions to make design have same 
feel across all pages

### Major concerns
- colors : text, background, gradient
- fonts : family, size, weight
- box-shadow
- 


Note: We have a namespace of the theme as our prefix. 
For example RUBY theme will start its variable with --ruby-*

Check example below 
post title, post detail, author name, links etc

- variables.css

```
:root {
    /* general colors */
    --ruby-light-text: #717171;
    --ruby-dark-text: #000000;
    --ruby-main-color: #C61639;
    --ruby-bg-gradient: linear-gradient(180deg, #ED213A 0%, rgba(134, 64, 131, 0) 100%), #67160E;

    /* general font */
    --ruby-font1-family: Merriweather;
    --ruby-font2-family: Roboto;
    --ruby-font-lg: 22px;
    --ruby-font-md: 20px;
    --ruby-font-sm: 14px;
    --ruby-font-xs: 12px;
    --ruby-line-height-lg: 32px;
    --ruby-line-height-md: 25px;
    --ruby-line-height-sm: 28px;
    --ruby-line-height-xs: 14px;

    /* box-model - margin, spacing, padding , border */
    --ruby-letter-spacing: -0.02em;
}
```

## Page level styling

1. Follow the approach used for theming below
2. Don't add extra css variables in page level styles
3. Only add css variables to the theme.css file if the variable is globally used.
4. Use bootstrap class to control most styling but not color and font, our variable will be used. 
5. Box-model (e.g margin, padding, layout, alignment) should be control by boostrap class
  e.g for div - px-3, mt-3, mr-3 etc based on your spacing
6. All styling should be in each theme asset folder with page name 
   e.g resources/themes/ruby/assets/draft.css belong to draft page
7. DO NOT USE INLINE STYLING for font, color.


#### External css file - page level

```

<style>

    /* light styles - doesnt need .light-mode parent since it is default */

    p {
        color: var(--ruby-dark-color);
        background: var(--ruby-light-bg);
    }

    /* dark styles - must have a .dark-mode parent class */

    .dark-mode p {
        color: var(--ruby-light-color);
        background: var(--ruby-dark-bg);
    }

    /* responsivenes style below -only for font, spacing and layout tweak */

    /* Extra small devices (<767px) */
    @media screen and (max-width: 767px) {

    }

    /* Small Devices (≥768px) */
    @media screen and (min-width: 768px) {
    
    }

    /* Medium Devices (≥992px) */
    @media screen and (min-width: 992px) {
    
    }

    /* Medium Devices (≥1200px) */
    @media screen and (min-width: 1200px) {
    
    }

</style>

```

#### Import to HTML file at the top - page level

```
<style>
    @import 'resources/themes/ruby/assets/draft.css'
</style>
```

#### Page level markup

```
{% set title = "Draft"%}
{% extends 'layout.html' %} {% block page_content%}

<style>
    @import 'resources/themes/ruby/assets/draft.css'
</style>

<section id="content" class="container">
    <!-- content goes here -->
    .
    .
    .
    <!-- content end here -->
</section>

{% endblock page_content %}
```


## Theming

- theme.css (sample of how theme use variables)

```

<style>

    /* light theme - default */

    .post-title {
        font-size: var(--ruby-font-lg);
        font-family: var(--ruby-font1-family);
        font-weight: bold;
        font-style: normal;
        line-height: --ruby-line-height-sm;
        color: var(--ruby-dark-text);
    }

    .post-detail {
        font-size: 12px;
        font-family: var(--ruby-font2-family);
        font-weight: bold;
        font-style: normal;
        line-height: var(--ruby-line-height-xs)
        color: var(--ruby-light-text);
    }

    /* dark mode - use .dark-mode parent class */
    
    .dark-mode .post-title {
        color: var(--ruby-dim-text);
    }

</style>

```

### Compiles and minifies for production

```
coming soon
```

