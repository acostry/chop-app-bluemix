chop-app-bluemix
================

A funny chop app build with php running on Bluemix

This is an intresting words app, when you input some word and click Generate, it will display in a cicle picture. 
This app is a modified version to running on Bluemix with PHP buildpack, the original version can be reached from: https://coding.net/u/phpbin/p/chop/git

Deploy app to Bluemix step by step
============================

1. Download app code to local, and unzip it.
2. Open cmd and go into the code root directory.
3. Login in Bluemix with CF command line: cf api https://api.ng.bluemix.net
4. cf login with your Bluemix ID and secret
5. Push app with PHP buildpack: cf push app_name -b https://github.com/acostry/cf-php-build-pack
6. Access your app by http://app_name.mybluemix.net
7. You can have a try with link: http://chop-php.mybluemix.net/

