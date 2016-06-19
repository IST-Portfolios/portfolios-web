# Welcome

## Getting Started

In order to run this project you should have the following pre-requisites installed in your OS:

1- [VirtualBox](https://www.virtualbox.org/)  
2- [Vagrant](https://www.vagrantup.com/)  
3- With those two installed, you should install the vagrant plugin: guest_ansible  
    3.1- `vagrant plugin install vagrant-guest_ansible`  
    4- Go into the project directory and run `vagrant up`.  
5- To check 2 working nginx servers:   
    5.1- `localhost:8888` shows you a phpinfo server  
    5.2- `localhost:11111` will serve as basis for the local development of the website - See Bootstraping section

## Bootstraping

So now you have your vagrant machine up and running but at `localhost:11111` there is only a blank page, se here are the next steps

* First lets clone the development version of the webportal @ `git clone git@51.255.35.181:isportal-dev.git isportal-dev` and we do so at `/vagrant/` directory; (the password should have been given to you by a developer or the repository manager)
* If you refresh the page what do you get? Still absolute nothing. This is due to the fact that the composer dependencies for the laravel project are not present, and you can verify that `.gitignore` sustains that the `/vendor` directory should be left out of the repository;
    * To fix this just run `composer install` at `/vagrant/isportal-dev`

* Now two things might happen: if you refresh and all is good, you are blessed and godspeed to you. If not, then there is a last step for you to do:
    * change the permissions on the folder `/storage` inside the portal folder (isportal-dev), and do so by running the following:
    * `sudo chmod -R gu+w storage`
    * `sudo chmod -R guo+w storage`

* Finally if you get an error about some invalid cypher: `php artisan key:generate` 
