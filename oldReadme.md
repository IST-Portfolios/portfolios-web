 Welcome
## THIS FILE NEEDS a REVIEW ###

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

* To fix this just run `composer install` at `/vagrant/isportal-dev`

* Now two things might happen: if you refresh and all is good, you are blessed and godspeed to you. If not, then there is a last step for you to do:
    * change the permissions on the folder `/storage` inside the portal folder (isportal-dev), and do so by running the following:
    * `sudo chmod -R gu+w storage`
    * `sudo chmod -R guo+w storage`

* After this you should run (in `/isportal-dev` directory)  `php artisan migrate && php artisan db:seed` - this will populate the database for you.
    * Make sure that you have .env file in this directory if you do not have this file please try to manually check out this item from the repository, since by default this item is ignored.

* Finally if you get an error about some invalid cypher: `php artisan key:generate`
## Download Reports as zip
For download the students reports you need to add this package: 
* `sudo apt-get install php7.0-zip

## Demo

[Portal Usability Demo](https://youtu.be/ykNUC7Uw4kk)

* Note that in the demo, bugs were not left out on purpose, it serves as a first glance at the state of development that it currently presents. If you watch the full demo you will be able to notice issues and derive necessities  
