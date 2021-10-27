<!DOCTYPE html>
<html lang="en">
<head>
    <title>Genome Payment Gateway Settings</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="height=device-height, width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <script src="https://d35z3p2poghz10.cloudfront.net/ecwid-sdk/js/1.2.5/ecwid-app.js"></script>
    <link rel="stylesheet" href="https://d35z3p2poghz10.cloudfront.net/ecwid-sdk/css/1.3.8/ecwid-app-ui.css"/>
    <link rel="stylesheet" href="/css/CssFw.css"/>
</head>
<body>
<div>
    <div>
        <div class="named-area">
            <div class="named-area__body">
                <div class="a-card a-card--normal">
                    <div class="a-card__paddings">
                        <div class="payment-method">
                            <div class="payment-method__header">
                                <div class="payment-method__logo">
                                    <img src="/img/logo.svg" alt="genome">
                                </div>
                            </div>
                            <div class="payment-method__title">Accept Genome payments on your website</div>
                            <div class="payment-method__content">
                                <div class="form-area">
                                    <div class="form-area__content">
                                        <p>To start accepting Genome payments, please enter Genome keys.</p>
                                    </div>

                                    <div class="columned">
                                        <div class="columned__item">
                                            <div class="form-area__title">Your Genome account keys:</div>
                                            <div class="form-area__content">
                                                <div class="fieldsets-batch">

                                                    <div class="fieldset">
                                                        <div class="fieldset__field-wrapper">
                                                            <div class="field field--medium">
                                                                <span class="fieldset__svg-icon"></span>
                                                                <label for="input-publicKey" class="field__label">Public Key</label>
                                                                <!-- Instruction title input. Use data attributes as below to save and update the value to/from application storage via functions.js -->
                                                                <input id="input-publicKey" data-name="publicKey" data-visibility="private" type="text" class="field__input">
                                                                <div class="field__placeholder">Public Key</div>
                                                                <span class="field-state--success"><svg xmlns="http://www.w3.org/2000/svg" width="26px" height="26px" viewBox="0 0 26 26" focusable="false"><path d="M5 12l5.02 4.9L21.15 4c.65-.66 1.71-.66 2.36 0 .65.67.65 1.74 0 2.4l-12.3 14.1c-.33.33-.76.5-1.18.5-.43 0-.86-.17-1.18-.5l-6.21-6.1c-.65-.66-.65-1.74 0-2.41.65-.65 1.71-.65 2.36.01z"></path></svg></span>
                                                                <span class="field-state--close"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16 16" enable-background="new 0 0 16 16" xml:space="preserve" focusable="false"><path d="M15.6,15.5c-0.53,0.53-1.38,0.53-1.91,0L8.05,9.87L2.31,15.6c-0.53,0.53-1.38,0.53-1.91,0 c-0.53-0.53-0.53-1.38,0-1.9l5.65-5.64L0.4,2.4c-0.53-0.53-0.53-1.38,0-1.91c0.53-0.53,1.38-0.53,1.91,0l5.64,5.63l5.74-5.73 c0.53-0.53,1.38-0.53,1.91,0c0.53,0.53,0.53,1.38,0,1.91L9.94,7.94l5.66,5.65C16.12,14.12,16.12,14.97,15.6,15.5z"></path></svg></span>
                                                            </div>
                                                            <div class="fieldset__field-prefix"></div>
                                                            <div class="fieldset__field-suffix"></div>
                                                        </div>
                                                        <div class="field__error" aria-hidden="true" style="display: none;"></div>
                                                        <div class="fieldset__note" aria-hidden="true" style="display: none;"></div>
                                                    </div>

                                                    <div class="fieldset">
                                                        <div class="fieldset__field-wrapper">
                                                            <div class="field field--medium">
                                                                <span class="fieldset__svg-icon"></span>
                                                                <label for="input-privateKey" class="field__label">Private Key</label>
                                                                <!-- Instruction title input. Use data attributes as below to save and update the value to/from application storage via functions.js -->
                                                                <input id="input-privateKey" data-name="privateKey" data-visibility="private" type="text" class="field__input">
                                                                <div class="field__placeholder">Private Key</div>
                                                                <span class="field-state--success"><svg xmlns="http://www.w3.org/2000/svg" width="26px" height="26px" viewBox="0 0 26 26" focusable="false"><path d="M5 12l5.02 4.9L21.15 4c.65-.66 1.71-.66 2.36 0 .65.67.65 1.74 0 2.4l-12.3 14.1c-.33.33-.76.5-1.18.5-.43 0-.86-.17-1.18-.5l-6.21-6.1c-.65-.66-.65-1.74 0-2.41.65-.65 1.71-.65 2.36.01z"></path></svg></span><span class="field-state--close"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16 16" enable-background="new 0 0 16 16" xml:space="preserve" focusable="false"><path d="M15.6,15.5c-0.53,0.53-1.38,0.53-1.91,0L8.05,9.87L2.31,15.6c-0.53,0.53-1.38,0.53-1.91,0 c-0.53-0.53-0.53-1.38,0-1.9l5.65-5.64L0.4,2.4c-0.53-0.53-0.53-1.38,0-1.91c0.53-0.53,1.38-0.53,1.91,0l5.64,5.63l5.74-5.73 c0.53-0.53,1.38-0.53,1.91,0c0.53,0.53,0.53,1.38,0,1.91L9.94,7.94l5.66,5.65C16.12,14.12,16.12,14.97,15.6,15.5z"></path></svg></span>
                                                            </div>
                                                            <div class="fieldset__field-prefix"></div>
                                                            <div class="fieldset__field-suffix"></div>
                                                        </div>
                                                        <div class="field__error" aria-hidden="true" style="display: none;"></div>
                                                        <div class="fieldset__note" aria-hidden="true" style="display: none;"></div>
                                                    </div>

                                                </div>
                                                <div class="inline-alert inline-alert--error">Genome accepts all debit and credit cards and more than 150 different currencies.</div>
                                            </div>
                                        </div>

                                        <!-- Payment instructions block START -->
                                        <div class="columned__item columned__item--shifted">
                                            <div class="form-area__title">Configure Account</div>
                                            <div class="form-area__content">
                                                <ul class="bullet">
                                                    <li>Log in to the <a href="https://merchant.genome.eu" target="_blank">Genome merchant portal</a>;</li>
                                                    <li>Click on the &laquo;Payment pages&raquo; section on the left side;</li>
                                                    <li>In &laquo;General section&raquo; fill up all required URLs;</li>
                                                    <li>Copy the values of the API keys to Ecwid settings;</li>
                                                    <li>Back to Genome merchant portal and turn on a payment method on the &laquo;Payment methods&raquo; section;</li>
                                                    <li>And the final step is to create a payment form on the &laquo;Payment form&raquo; section.</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- Payment instructions block END -->

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/js/functions.js"></script>
<script src="https://d35z3p2poghz10.cloudfront.net/ecwid-sdk/css/1.3.8/ecwid-app-ui.min.js"></script>

<script>

    // Autosave feature for fields. Complimentary JS for the one from SDK above

    (function initFieldset() {

        var elms = document.querySelectorAll('.field__input, .field__select, .field__textarea, .radio, .custom-checkbox__input');
        for (var i = 0; i < elms.length; i++) {
            elms[i].addEventListener('blur', function(e) {
                checkFieldChange(this);
                if (this.classList.contains('field__input') || this.classList.contains('field__textarea')) {
                    saveUserData();
                }
            }, false);

            elms[i].addEventListener('change', function() {
                if (this.value) {
                    saveUserData();
                }
                else {
                    saveUserData();
                }
            }, false);

            elms[i].addEventListener('click', function() {
                if (this.value) {
                    saveUserData();
                }
                else {
                    saveUserData();
                }
            }, false);
        }
    })();

</script>

</body>
</html>
