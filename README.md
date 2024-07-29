# Simplified Payment System

## Tools used for development

- Laravel Framework 9.52.16
- Postgres
- Docker

## What is the idea of this piece of code?

todo...

## How to setup and run?

In any of the cases you are going to need docker installed on your local machine

### Using the MakeFile

The makefile is just a shortcut for the next step, so if you already have make or don't mind installing it, just run ``make`` on the terminal and it should take care of the setup.

In the make setup step I had to add the `sleep 2` command. It's a hack to avoid a connection issue with the database when running the migrations.

### Using docker

The easiest way to run is using docker. First you need to have docker installed. And then you run the following:

```
docker compose up -d
```

If everything goes right, you should have now two containers, the simplified_pay_postgres_database and the simplified_pay_backend. Check this using the following command:

```
docker ps | grep simplified_pay
```

Then run the command.

```
docker exec simplified_pay_backend php artisan optimize; php artisan migrate
```

And it is ready to go, in theory :)

## How do I know it's working?

Go to http://localhost:8000 and see if the laravel welcome page appears. If it doesn't, something went wrong :(
