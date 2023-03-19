<?php
@session_start();

use Byte\Request;
?>

<!DOCTYPE html>
<html lang="en-US">

<head>
    <title>Blocked by ByteShield</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="robots" content="noindex,nofollow">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            line-height: 1.15;
            -webkit-text-size-adjust: 100%;
            color: #313131;
        }

        html,
        button {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto,
                Helvetica Neue, Arial, Noto Sans, sans-serif, Apple Color Emoji,
                Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        a {
            transition: color 0.15s ease;
            background-color: transparent;
            text-decoration: none;
            color: #0051c3;
        }

        a:hover {
            text-decoration: underline;
            color: #ee730a;
        }

        .hidden {
            display: none;
        }

        .main-content {
            margin: 8rem auto;
            width: 100%;
            max-width: 60rem;
        }

        .heading-favicon {
            margin-right: 0.5rem;
            width: 2rem;
            height: 2rem;
        }

        @media (max-width: 720px) {
            .main-content {
                margin-top: 4rem;
            }

            .heading-favicon {
                width: 1.5rem;
                height: 1.5rem;
            }
        }

        .main-content,
        .footer {
            padding-right: 1.5rem;
            padding-left: 1.5rem;
        }

        .main-wrapper {
            display: flex;
            flex: 1;
            flex-direction: column;
            align-items: center;
        }

        .font-red {
            color: #b20f03;
        }

        .spacer {
            margin: 2rem 0;
        }

        .h1 {
            line-height: 3.75rem;
            font-size: 2.5rem;
            font-weight: 500;
        }

        .h2 {
            line-height: 2.25rem;
            font-size: 1.5rem;
            font-weight: 500;
        }

        .core-msg {
            line-height: 2.25rem;
            font-size: 1.5rem;
            font-weight: 400;
        }

        .body-text {
            line-height: 1.25rem;
            font-size: 1rem;
            font-weight: 400;
        }

        .expandable-title {
            line-height: 1.5rem;
            font-weight: 500;
        }

        @media (max-width: 720px) {
            .h1 {
                line-height: 1.75rem;
                font-size: 1.5rem;
            }

            .h2 {
                line-height: 1.5rem;
                font-size: 1.25rem;
            }

            .core-msg {
                line-height: 1.5rem;
                font-size: 1rem;
            }
        }

        .icon-wrapper {
            display: inline-block;
            position: relative;
            top: 0.25rem;
            margin-right: 0.2rem;
        }

        .heading-icon {
            width: 1.625rem;
            height: 1.625rem;
        }

        @media (max-width: 720px) {
            .heading-icon {
                width: 1.25rem;
                height: 1.25rem;
            }
        }

        .warning-icon {
            display: inline-block;
            background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADQAAAA0CAMAAADypuvZAAAAPFBMVEUAAACvDwOyDwKyDwOvEACyDgOyDwKvDwKwDgCyDgKxDgOyDgKvDgKyDwKyDgOxDgKzDgKxDgKxEASyDwMgW5ZmAAAAE3RSTlMAQN+/EJDvMB9wYJ9Qz7CAf6CAtGoj/AAAAcFJREFUSMeVltu2gyAMRLlfBDxt+f9/PTq2VXSwmod2GdhkEoIiiPmYinK1VqXt4MUFk9bVxlTyvxBdienhNoJwoYMY+57hdMzBTA4v4/gRaykT1FuLNI0/j/1g3i2IJ8s9F+owNCx+2UlWQXbexQFjjTjN1/lGALS9xIm9QIXNOoowlFKrFssYTtmvuOXpp2HtT6lUE3f11bH1IQu9qbYUBEr7yq8zCxkWuva8+rtF4RrkP6ESxFPoj7rtW30+jI4UQlZuiejEwZ4cMg65RKjjUDz6NdwWvxw6nnLESEAl230O5cldUAdy8P44hJZTYh40DOIKzFw3QOI6hPk9aDiFHJc3nMirKERgEPd7FKKgiy5DEn3+5JsrAfHNtfjVRLucTPTaCA1rxFVz6AX8yYsIUlXoMqbPWFUeXF1Cyqz7Ej1PAXNBs1B1tsKWKpsX0yFhslTetL4mL8s4j2fyslTbjbT7Va2V7GCG5ukhftijXdsoQhGmzSI4QhHGhVufz4QJ/v6Hug6dK0EK3YuM8/3Lx5h3Z0STywe55oxRejM5Qo4aAtZ8eTBuWp6dl3IXgfnnLpyzBCFctHomnSopejLhH/3AMfEMndTJAAAAAElFTkSuQmCC);
            background-size: cover;
        }

        .text-center {
            text-align: center;
        }

        .expandable {
            transition: height, border-left 0.2s;
            border-left: 0.125rem solid #e5e5e5;
            padding-left: 0.5rem;
        }

        .expandable.expanded {
            border-left-color: #0051c3;
        }

        .expandable-summary-btn {
            border: none;
            background: none;
            cursor: pointer;
            padding: 0;
            color: inherit;
            font: inherit;
        }

        .expandable-details {
            display: none;
            padding: 0.5rem 0;
        }

        .expanded>.expandable-details {
            display: block;
        }

        .caret-icon {
            display: inline-block;
            transition: transform 0.2s;
            background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgBAMAAACBVGfHAAAAElBMVEUAAAAwMDAxMTEyMjIwMDAxMTF+89HTAAAABXRSTlMAgF9/MMasjJIAAABTSURBVCjPzcq7DcAwDANR5TOAm/Rp0meErBAD3n8VW8DBt4JZUALxYp18vmfWUR2ed9TW7iB7K3muOsGfDRFAABKABCABSAASgAQgAUgAkhKLpwMJmwrD+BDiYwAAAABJRU5ErkJggg==);
            background-size: contain;
            width: 1rem;
            height: 1rem;
        }

        .caret-icon-wrapper {
            position: relative;
            top: 0.1rem;
            margin-left: 0.2rem;
        }

        .expanded .caret-icon {
            transform: rotate(180deg);
        }

        .big-button {
            transition-duration: 0.2s;
            transition-property: background-color, border-color, color;
            transition-timing-function: ease;
            border: 0.063rem solid #0051c3;
            border-radius: 0.313rem;
            padding: 0.375rem 1rem;
            line-height: 1.313rem;
            font-size: 0.875rem;
        }

        .big-button:hover {
            cursor: pointer;
        }

        .webauthn-prompt {
            align-items: center;
        }

        .captcha-prompt:not(.hidden),
        .webauthn-prompt:not(.hidden) {
            display: flex;
        }

        .webauthn-divider {
            padding: 0 1.5rem;
        }

        @media (max-width: 720px) {

            .captcha-prompt:not(.hidden),
            .webauthn-prompt:not(.hidden) {
                flex-wrap: wrap;
                justify-content: center;
            }

            .webauthn-divider {
                margin: 1rem 0;
                width: 100%;
                text-align: center;
            }
        }

        .webauthn-button {
            background-color: #fff;
            color: #0051c3;
        }

        .webauthn-button:hover {
            border-color: #003681;
            background-color: #003681;
            color: #fff;
        }

        .pow-button {
            margin: 2rem 0;
            background-color: #0051c3;
            color: #fff;
        }

        .pow-button:hover {
            border-color: #003681;
            background-color: #003681;
            color: #fff;
        }

        .footer {
            margin: 0 auto;
            width: 100%;
            max-width: 60rem;
            line-height: 1.125rem;
            font-size: 0.75rem;
        }

        .footer-inner {
            border-top: 1px solid #d9d9d9;
            padding-top: 1rem;
            padding-bottom: 1rem;
        }

        .ip-address {
            margin-left: 2.25rem;
        }

        .clearfix:after {
            display: table;
            clear: both;
            content: "";
        }

        .clearfix .column {
            float: left;
            padding-right: 1.5rem;
            width: 50%;
        }

        .diagnostic-wrapper {
            margin-bottom: 0.5rem;
        }

        .footer .ray-id {
            text-align: center;
        }

        .footer .ray-id code {
            font-family: monaco, courier, monospace;
        }

        .core-msg,
        .zone-name-title {
            overflow-wrap: break-word;
        }

        @media (max-width: 720px) {
            .diagnostic-wrapper {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
            }

            .clearfix:after {
                display: initial;
                clear: none;
                text-align: center;
                content: none;
            }

            .column {
                padding-bottom: 2rem;
            }

            .clearfix .column {
                float: none;
                padding: 0;
                width: auto;
                word-break: keep-all;
            }

            .zone-name-title {
                margin-bottom: 1rem;
            }
        }

        .loading-spinner {
            height: 76.391px;
        }

        .lds-ring {
            display: inline-block;
            position: relative;
            width: 1.875rem;
            height: 1.875rem;
        }

        .lds-ring div {
            box-sizing: border-box;
            display: block;
            position: absolute;
            border: 0.3rem solid #595959;
            border-radius: 50%;
            border-color: #595959 transparent transparent transparent;
            width: 1.875rem;
            height: 1.875rem;
            animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
        }

        .lds-ring div:nth-child(1) {
            animation-delay: -0.45s;
        }

        .lds-ring div:nth-child(2) {
            animation-delay: -0.3s;
        }

        .lds-ring div:nth-child(3) {
            animation-delay: -0.15s;
        }

        @keyframes lds-ring {
            0% {
                transform: rotate(0);
            }

            to {
                transform: rotate(360deg);
            }
        }

        @media screen and (-ms-high-contrast: active),
        screen and (-ms-high-contrast: none) {

            body,
            .main-wrapper {
                display: block;
            }
        }

        body.no-js .loading-spinner {
            visibility: hidden;
        }

        body.no-js .challenge-running {
            display: none;
        }

        @media (prefers-color-scheme: dark) {
            body {
                background-color: #222;
                color: #d9d9d9;
            }

            a {
                color: #fff;
            }

            a:hover {
                text-decoration: underline;
                color: #ee730a;
            }

            .lds-ring div {
                border-color: #999999 transparent transparent transparent;
            }

            .font-red {
                color: #fc574a;
            }

            .big-button,
            .webauthn-button,
            .pow-button {
                background-color: #4693ff;
                color: #1d1d1d;
            }

            .expandable.expanded {
                border-left-color: #4693ff;
            }
        }
    </style>
</head>

<body class="no-js">
    <div class="main-wrapper" role="main">
        <div class="main-content">
            <h1 class="zone-name-title h1">
                <?php echo $_SERVER['SERVER_NAME']; ?>
            </h1>
            <h2 class="h2" id="challenge-running">
                ByteShield
            </h2>
            <noscript>
                <div id="challenge-error-title">
                    <div class="h2">
                        <span class="icon-wrapper">
                            <div class="heading-icon warning-icon"></div>
                        </span>
                        <span id="challenge-error-text">
                            Enable JavaScript and cookies to continue
                        </span>
                    </div>
                </div>
            </noscript>
            <div id="challenge-body-text" class="core-msg spacer">
                You has ben blocked by ByteShield Protection! <?php
                                                                if (@$_SESSION['error'] == 'attack') {
                                                                    echo 'Server Is attacked!';
                                                                }
                                                                unset($_SESSION['error']);
                                                                ?>
            </div>
        </div>
    </div>



    <div class="footer" role="contentinfo">
        <div class="footer-inner">
            <div class="clearfix diagnostic-wrapper">
                <div class="ray-id">Request ID: <code><?php echo @$_SESSION['requestId']; ?></code><br>IP: <?php echo Request::getIP(); ?></div>
            </div>
            <div class="text-center" id="footer-text">Performance &amp; security by <a rel="noopener noreferrer" href="https://bytecloud.pl/" target="_blank">ByteCloud.pl</a></div>
        </div>
    </div>
</body>

</html>