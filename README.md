![alt text](http://www.pharaohtools.com/images/logo-pharaoh.png "Pharaoh Tools Build Server")

# PTBuild, Pharaoh Tools

## About:

Build and Monitoring in PHP. Integrate Builds for your application. Build Automation and Process Automation in PHP.

A Web Interface for your your automated build processes, flexible to be distributed from Development through
Enterprise Production.

Smooth Integration with all other Pharaoh Tools; seamlessly and simply being able to hooking into your Development
Environments, Configuration, Deployments, Tests, Tracked Processes and Managed Orchestration.

    
## Installation

First you'll need to install Git and PHP5. If you don't have either, google them - they're easy to install. To install
ptbuild cli on your On your Mac, Linux or  Unix Machine silently do the following:

git clone https://github.com/PharaohTools/ptbuild.git && sudo php ptbuild/install-silent

or on Windows, open a terminal with the "Run as Administrator" option...

git clone https://github.com/PharaohTools/ptbuild.git && php ptbuild\install-silent

... that's it, now the ptbuild command should be available at the command line for you.


## Usage:

So, there are a few simple commands...

First, you can just use

ptbuild

...This will give you a list of the available modules...

Then you can use

ptbuild *ModuleName* help

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