### Initial Requirements
1. PHP version 8.2 or above
2. Symfony cli for local server 

### Initial setup
1. create a .env file using .env-sample file
1. Run `composer install`
2. Create DB `php bin/console doctrine:database:create`
3. Create DB tables `php bin/console doctrine:schema:create`
4. Load DB fixtures `php bin/console doctrine:fixtures:load`
5. Start local server `symfony serve`

### How to use
Browse /api/login_check, provide username & password in request body, if authentication is successful, you will get bearer token which can be used in all other api endpoints for authorization

