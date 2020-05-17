[![Maintainability](https://api.codeclimate.com/v1/badges/617608fe563fa8683c19/maintainability)](https://codeclimate.com/github/tcheuD/bilemo/maintainability)

# Installation
- clone the repository
- open your console and go to the project directory :
    ```
   composer install
   composer dump-env prod
    ```
- go to .env.local.php
    - Update DATABASE_URL with your environement : 
        ```
        'DATABASE_URL' => 'DATABASE_URL=mysql://root@localhost:3306/bilemo?serverVersion=5.7',
        ```
        
### Create the database and load fixtures
- in your console :
   ```
   ./bin/console doctrine:database:create
   ./bin/console make:migration
   ./bin/console doctrine:migrations:migrate
   ./bin/console doctrine:fixtures:load
   ```
   
### Generate the SSH keys:
```
    $ mkdir -p config/jwt
    $ openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
    $ openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout
```
If needed, edit JWT_PASSPHRASE in .env or .env.local
  
### Tests:
- Setup the test db
```
   ./bin/console doctrine:database:create --env=test
   ./bin/console doctrine:migrations:migrate --env=test
   ./bin/console doctrine:fixtures:load --env=test
```
- Run the test with
```
    ./bin/phpunit
```

If needed, edit JWT_PASSPHRASE in .env or .env.local
     
### Start the server in local
 - in your console :
     ```
     ./bin/console server:run
     ```
