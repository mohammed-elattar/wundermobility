# WunderMobility task

## Prerequisites

Make sure [Docker Desktop for Mac or PC](https://www.docker.com/products/docker-desktop) is installed and running, or head [over here](https://docs.docker.com/install/) if you are a Linux user. You will also need a terminal running [Git](https://git-scm.com/) and [Bash](https://www.gnu.org/software/bash/).

This setup also uses localhost's ports 80 and 443, so make sure those are available.

## Directions of use

Add the following domains to your machine's `hosts` file:

```
127.0.0.1 backend.wundermobility.task frontend.wundermobility.task phpmyadmin.wundermobility.task
```

Add the following function to your Bash start-up file (`.bashrc`, `.zshrc`...):

```
function wundermobility {
    cd <PATH>/wundermobility && bash wundermobility $*
        cd -
}
```

Where `<PATH>` is the absolute path leading to the folder where the repository was cloned.

Open a new terminal window or `source` your Bash start-up file for the changes to take effect, then run the following command:

```
$ wundermobility init
```

This will download and build the images listed in `docker-compose.yml`, create and start the corresponding containers, and take other various steps to set up the project (this might take a while).

You're also likely to be prompted for your system account's password to install the SSL/TLS self-signed certificate, unless you're on Windows, in which case you'll need to install it [manually](https://www.thewindowsclub.com/manage-trusted-root-certificates-windows) (you will find it under `.docker/nginx/certs`).

Once the script is done, you can visit [frontend.wundermobility.task](https://frontend.wundermobility.task) and [backend.wundermobility.task](https://backend.wundermobility.task).

Learn about the available commands by displaying the menu:

## Content

This branch contains a [three-tier architecture](https://www.techopedia.com/definition/24649/three-tier-architecture) application running on a LEMP stack, supported by Docker and orchestrated by Docker Compose.

It includes:

* A container for Nginx;
* A container for the backend application (based on [Laravel](https://laravel.com/));
* A container for the frontend application (based on [Vue.js](https://vuejs.org/));
* A container for MySQL;
* A container for phpMyAdmin;
* A volume to persist MySQL data;

The containers are based on Alpine images when available, for an optimised size.

This will download and build the images listed in `docker-compose.yml`, create and start the corresponding containers, and take other various steps to set up the project (this might take a while).

You're also likely to be prompted for your system account's password to install the SSL/TLS self-signed certificate, unless you're on Windows, in which case you'll need to install it [manually](https://www.thewindowsclub.com/manage-trusted-root-certificates-windows) (you will find it under `.docker/nginx/certs`).

Learn about the available commands by displaying the menu:

## Explanation
I added a bash file that wrappping all commands needed , 
however after you run 
```
$ wundermobility init
```
you don't need any ,you can access the services from 

```
https://backend.wundermobility.task
https://frontend.wundermobility.task
https://phpmyadmin.wundermobility.task
```

however you can show the commands help by only 

```
wundermobility
```

### Testing
You can run the backend tests by running this command

```
wundermobilty artisan test 
```

## What's Done Already?

##Backend
```
* I created an endpoint for registering a new user 
  , models, requet validations, testing
* I created adapter to request a 3rd party to get paymentId
```
##To be improved on Backend
```
* Add jwt token to the user after registered successfully
* Add transaction to wrap all requests to the database to save the address,payment inf, personal info
```
##Frontend
```
* I used vuetify to get the multistepp form
* I adapted it a bit to the task needs
* I am using local storage and events to share the databetween the 
  components and get access to the same step the user left
```
##To be improved on FrontEnd
```
* using Router to move to a sucess page after saving 
* using vuex as a state management instead of firing events
* adding some unit testing
```
