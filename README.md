## Setup Project

- I am using Laravel and Mysql.
- Using Dokcer version 4.24
- for setup  please create a database schema
- update ENV file with Database env variables for example

```
    DB_CONNECTION=mysql
    DB_HOST=database
    DB_PORT=3306
    DB_DATABASE=homestead
    DB_USERNAME=root
    DB_PASSWORD=developer@1
```
- Sorry i forgot to add earlier, please do add this RapidApi(Currency Converter) key in ENV for Currency excange to work.

```
CURRENCY_API_KEY=4f7822cb4fmsh93ff310da7**********
```
- Before running docker you can run this command inside Docker folder:
this command will make sure you have right permissions to run some artisan commands to setup project

```
chmod +x entrypoint.sh
```

- Run docker 

```
docker-compose up --build -d
```

- Run migrations: 
```
docker exec mintos-task-main-php-1 php artisan migrate
```

- Run data seeders:
```
docker exec mintos-task-main-php-1 php artisan db:seed
```

- you can run test using 

```
docker exec mintos-task-main-php-1 php artisan test
```


## Endpoints

- Get all accounts using client id
```
GET http://localhost:8000/api/v1/accounts/{clientId}
```

- Get all transactions history

```
http://localhost:8000/api/v1/transactions?account_id={accountId}&offset=0&limit=5
```

- Transfer money from account to another using account ids

```
POST http://localhost:8000/api/v1/accounts/transfer
'senderAccountId': 'asasa'
'receiverAccountId': '232323',
'amount' => 30,
'currency' => 'USD'
```