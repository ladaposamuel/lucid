## How to create the pages

- all page names should be the same name on the figma board
- use bootstrap wherever possible to minimize CSS
- use CSS variables for consistency in colors
- when using bootstrap files, be sure to import the minified versions only.
- javascript dependencies for bootstrap will be imported over a CDN
- anything that cannot be done in bootstrap should then be done using vanilla JS or CSS
- bootsrap has already been added locally to the `assets` folder

```html
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Document</title>
    <link rel="stylesheet" href="PATH TO MINIFIED BOOTSTRAP CSS" />
  </head>
  <body>
    <!-- Copy these for bootstrap javascript dependencies -->
    <script
      src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
      integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
      integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
      crossorigin="anonymous"
    ></script>
    <script src="PATH TO MINIFIED JAVSCRIPT CSS"></script>
  </body>
</html>
```
