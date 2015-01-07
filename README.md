


















cleopatraenterprise phrankinsense install --yes --guess
cd /opt/phrankinsense/phrankinsense/src/Modules/PostInput
dapperstrano vhe add --yes --guess --vhe-url=www.phrankinsense.tld --vhe-default-template-name=docroot-no-suffix
dapperstrano he add --yes --guess --host-name=www.phrankinsense.tld














































# Phrankinsense, Pharaoh Tools

## About:

Build and Monitoring in PHP. Integrate Builds for your application.

This is part of the Pharaoh Tools suite, which covers Configuration Management, Test Automation Management, Automated
Deployment, Build and Release Management and more, all implemented in code, and all in PHP.

Its easy to write modules for any Operating System but we've begun with Ubuntu and adding more as soon as possible.
Currently, all of the Modules work on Ubuntu 12-14, most on Centos and Windows.

    
## Installation

First you'll need to install Git and PHP5. If you don't have either, google them - they're easy to install. To install
phrankinsense cli on your On your Mac, Linux or  Unix Machine silently do the following:

git clone https://github.com/PharaohTools/phrankinsense.git && sudo php phrankinsense/install-silent

or on Windows, open a terminal with the "Run as Administrator" option...

git clone https://github.com/PharaohTools/phrankinsense.git && php phrankinsense\install-silent

... that's it, now the phrankinsense command should be available at the command line for you.


## Usage:

So, there are a few simple commands...

First, you can just use

phrankinsense

...This will give you a list of the available modules...

Then you can use

phrankinsense *ModuleName* help

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