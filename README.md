# PHPUK19 Nexmo Hackathon

## Setup

* Register for Nexmo
* Find your API keys at https://dashboard.nexmo.com/settings
* Run `cp config.sample.php config.php`
* Fill in your API keys
* Run `composer install -o`
* Deploy `index.php`, `config.php`, `.htaccess` and `vendor` to a server
* Register a number on Nexmo; add your domain followed by `/webhooks/inbound-sms` to the inbound SMS webhook

## Use

Text your registered number with a message e.g.

> Who should buy beer: john, paul, george, ringo

You should receive a return text e.g.

> john should buy beer
