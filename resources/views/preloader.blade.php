<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <title>preloader</title>
        <!-- Import this into the the page it's needed and toggle a class of "preloader-active" on the body tag -->
        <style>
            .preloader-wrapper{
                display: none;
            }
            .preloader-active .preloader-wrapper {
                display: block;
                width: 100vw;
                height: 100vh;
                background: #ffffff;
                position: fixed;
                z-index: 1000;
                top: 0;
                left: 0;
            }
            .spinner {
                width: 10vw;
                height: 10vw;
                border-radius: 50%;
                border: 4px solid;
                border-top-color: var(--main-color);
                border-bottom-color: var(--main-color);
                border-left-color: transparent;
                border-right-color: transparent;
                animation: rotate .5s infinite linear;
                position: absolute;
                top: 30%;
                left: 42%;
                transform: translateX(50%);
            }
            @keyframes rotate {
                0% {
                    transform: rotate(0deg);
                }
                100% {
                    transform: rotate(360deg);
                }
            }
        </style>
    </head>
    <body class="preloader-active">
        <div class="preloader-wrapper">
            <div class="spinner"></div>
        </div>
    </body>
</html>
