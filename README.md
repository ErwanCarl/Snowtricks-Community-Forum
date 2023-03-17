# P6 Openclassrooms - Snowtricks - Erwan Carlini

[![SymfonyInsight](https://insight.symfony.com/projects/00c7f3e9-6c00-46bf-be2e-77835a3f9bd7/big.svg)](https://insight.symfony.com/projects/00c7f3e9-6c00-46bf-be2e-77835a3f9bd7)
---------------

## Starting project


### Requirements

- PHP : ⩾ 8.1.0 
- MySQL ⩾ 8.0.30
- Composer
- Symfony 6.2
- Symfony CLI
- NPM 

### Packages Installation

First, clone project and place the project in a new folder, then install all composer packages with command line : ``composer install``.  

### Database datas

First, you will need to change the value of DATABASE_URL in the file .env to match with your database parameters, then create your database Snowtricks.  

To get all necessaries datas :  
* Run ``symfony console doctrine:database:create`` in command to create your database  
* Run ``symfony console doctrine:migration:migrate`` in command to create your tables in your DB from the entities files  
* Run ``php bin/console doctrine:fixtures:load`` to get the basic datas of this project  
* Run ``npm run watch`` to use node for dynamic features used in the project  
* Run ``symfony serve -d`` to use symfony CLI server  

### Mailer configuration settings  

Then, we need to configure the .env file to start the project correctly and use the sending mail features.     
You will have to change the value of MAILER_DSN in the .env file to match with your mailer parameters.  

### Admin features

If you want to get all access in the project, you can give yourselves the admin role by adding the value "ROLE_ADMIN" in the JSON, in the 'user' table column 'roles' on your account row.  

## Libraries use list

* Symfony  
* Doctrine  
* Twig 
