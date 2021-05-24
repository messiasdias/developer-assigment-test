# Developer assignment Test - Kevi.io 

## Get Started

The first step is to clone the project, done that enter the root directory of the repository, navigate between the directories respectively to install the necessary packages for operation.

Assuming it is in the root directory, run the command below to enter the directory to work on, install the packages, run App build (In the case of the Front-end), Migrations and tests (In the case of the API)

## API

### Install

```
cd api
composer install
```

If no exists, create a non-root file of the directory according to .env.example. 
Here are examples of using the Mysql and Sqlite databases.

### Test
```
composer test
```

### Migrate and Seed DB

Pass parameters to the seed migration scripts using the following notation passing the current enviroment context
respectively for development, test and production:

* composer migrate - -e devlopment (default)

* composer migrate - -e production

* composer migrate - -e testing

The same steps apply to the Seeds classes.

Obs:
When running the test, the `testing` environment assumes the migrate and seed commands, defaults to environment` development`.

```
composer migrate
composer seed
```

> Make Files Seeders or Migration Classes (Optional)
```
composer make:migration ClassNameCamelCase
composer make:seed ClassNameCamelCase
```

### Run development Server
Run development serve and, this is up listen the port 0.0.0.0:8090

```
composer dev
```


## APP
### Install

From this moment on, assuming it is in the application's root directory, around the following commands:

```
cd app
npm install
npm run cp-env
```

### Build and/or Run Dev Server

Run the command below respectively,
For application build and / or Run development server has arrived.

The files to be made available for production will be built in the dist/.

Development server developed on port 0.0.0.0:8080

```
npm run build
npm run dev
```

[By: Messias Dias](https://github.com/messiasdias)