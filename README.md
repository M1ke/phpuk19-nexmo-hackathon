# PHPUK19 Nexmo Hackathon

## Setup - Nexmo

* Register for Nexmo
* Find your API keys at https://dashboard.nexmo.com/settings
* Install Nexmo CLI: `npm install nexmo-cli -g`
* Run `nexmo setup <api_key> <api_secret>`
* Find a number to register with `nexmo number:search GB --sms`
* Buy that number with `nexmo number:buy xxxxxx` with the number you want
* Link it to your callback with `nexmo link:sms xxxxx http://your-domain/webhooks/inbound-sms`

## Setup - PHP

* Run `cp config.sample.php config.php`
* Fill in your API keys
* Run `composer install -o`
* Deploy `index.php`, `config.php`, `.htaccess` and `vendor` to a server

## Use

Text your registered number with a message e.g.

> Who should buy beer: john, paul, george, ringo

You should receive a return text e.g.

> john should buy beer

## Example

Send a text in the above format to +447520632463 
