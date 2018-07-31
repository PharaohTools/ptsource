# Pharaoh Repositories
![alt text](http://www.pharaohtools.com/images/logo-pharaoh.png "Pharaoh Tools Logo")


## About:

Binary File and Source Code Repository Management Server. Fully featured Web Server for Git Repositories and Binary File
Repositories. 

A Web Interface for your your automated source processes, flexible to be distributed from Development through
Enterprise Production.

Smooth Integration with all other Pharaoh Tools; seamlessly and simply being able to hooking into your Development
Environments, Configuration, Deployments, Tests, Tracked Processes and Managed Orchestration.

    

## Looky, looky...

Here's some pictures of Pharaoh Source in action


## Installing

If you just want to see how Pharaoh Track works, have a look a the demo...
http://source.demo.pharaohtools.com

#### Local or Cloud
If you want to install a local version on your workstation, or you want to install on a cloud/internet server, first
install Pharaoh Configure using instructions here...

*http://www.pharaohtools.com/install*


#### Local
Then for a workstation install run this (N.B. This is probably only useful for testing unless you want an issue sourceer to use by yourself)... 

``
ptconfigure ptsource install -yg # This will guess a local install with the url www.pharaoh.tld
``

  
#### Cloud
Or install to a cloud server with one of these ...

``
ptconfigure ptsource install -yg --vhe-url=source.mydomain.com --vhe-ip-port=1.2.3.4:80 # Specific IP
``

``
ptconfigure ptsource install -yg --vhe-url=source.mydomain.com --vhe-ip-port=0.0.0.0:80 # All IP's
``

``
ptconfigure ptsource install -yg --vhe-url=source.mydomain.com --vhe-ip-port=0.0.0.0:80 --enable-ssl # Also install and configure HTTPS using a Lets Encrypt certificate
``

  
#### Developer
If you're a developer, who wants to contribute, you'll want to run inside the Virtual Machine, so that you can easily
rebuild your front end changes, and work without affecting your host machine...
- First install Pharaoh Configure, Deploy and Virtualize, using the instruction here:
  - *http://www.pharaohtools.com/install*
- Git clone this repo
- Run the Development Virtual Machine using:
  - Virtualize GUI or 
  - the following command from the root of this repository
  ``
  ptvirtualize up now --mod --pro --step-times --step-numbers
  ``
- The Virtual machine will take a few minutes to set itself up
- The URL http://source.pharaohtools.vm:8059 will now show your development version of Pharaoh Track 
- The URL http://build.pharaohtools.vm:8059 will now show your build jobs, with automated tasks for the Virtual Machine
Development Environment




## Usage:

The following URL contains a bunch of tutorials

http://www.pharaohtools.com/tutorials



## Kudos

