![alt text](http://www.pharaohtools.com/images/logo-pharaoh.png "Pharaoh Tools Source Server")

# PTSource, Pharaoh Tools

## About:

Source Control Management in PHP.

A Web Interface for your your automated source processes, flexible to be distributed from Development through
Enterprise Production.

Smooth Integration with all other Pharaoh Tools; seamlessly and simply being able to hooking into your Development
Environments, Configuration, Deployments, Tests, Tracked Processes and Managed Orchestration.

    
## Installation

First you'll need to install Git and PHP5. If you don't have either, google them - they're easy to install. To install
ptsource cli on your On your Mac, Linux or  Unix Machine silently do the following:

git clone https://github.com/PharaohTools/ptsource.git && sudo php ptsource/install-silent

or on Windows, open a terminal with the "Run as Administrator" option...

git clone https://github.com/PharaohTools/ptsource.git && php ptsource\install-silent

... that's it, now the ptsource command should be available at the command line for you.


## Usage:

So, there are a few simple commands...

First, you can just use

ptsource

...This will give you a list of the available modules...

Then you can use

ptsource *ModuleName* help

...This will display the help for that module, and tell you a list of available alias for the module command, and the
available actions too.

You'll be able to automate any action from any available module into an autopilot file, or run it from the CLI. I'm
working on a web front end, but you can also use JSON output and the PostInput module to use any module from an API.


## Or some examples

The following URL contains a bunch of tutorials

http://www.pharaohtools.com/tutorials

Go to http://www.pharaohtools.com for more

---------------------------------------
Visit www.pharaohtools.com for more
******************************