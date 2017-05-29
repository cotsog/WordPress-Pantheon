#!/usr/bin/php -q
<?php
###############################################################
# @todo expand logic and refactor
#                     Setup script
# to run script call : <scriptname> <sitename> <action>
#                 eg : smi_conf.php strathcom-cms deploy
###############################################################
###############################################################

# Constants
#define("USER", " ");
#define("FILENAME", "myfile");

function options( $argc , $argv ){
  $command = $argv[1];

    switch ($command) {
      case 'deploy':
          deploy();
          break;
      case 'setup':
          setup_env();
          break;
      case 'setup_local_db':
          setup_local();
          break;
      case 'test':
          test();
          break;
      default:
          default_handler($command);
    }

}

# deploy
# run merge to production from master
function deploy() {
  echo "\n";
  echo "Deploying to dev environment on Pantheon...\n";
  sleep(7);
  echo "\n";
  $output = `chmod 755 deploy.sh`;
#  $output = `./deploy.sh`;
}

function setup_env(){
  echo "\n";
  echo "Setting up for unifying test and dev to match the live site...\n";
  echo "\n";
  $output = `chmod 755 unify-env.sh`;
  $output_ = `./unify-env.sh`;
}

# Setup local VVV
function setup_local() {
  echo "\n";
  echo "Setting up multisite db..\n";
  echo "\n";
  $output = `chmod 755 ms-local.sh`;
  $output_ = `./ms-local.sh`;
}

# creates log with user and saves to file
function logger($a,$b,$c){

}

function test() {
  echo "\n";
  echo "TEST HIT...\n";
  sleep(7);
  echo "\n";
}

# @todo expand logic
# takes care of user error to default
function default_handler($command){

  #$handle = fopen ("php://stdin","r");

  #echo "Insert new command : ";
  #sleep(3);

  #$line = trim(fgets($handle));
#  $sol[1] = $line;
#  options('false' , $sol);

#  if(trim($line) != 'yes'){
#     echo "ABORTING!\n";
#     exit;
#  }
exit("
The command '$command' is not available:
To execute this script
Your options are :
i. deploy,
ii. setup ( to set up your local env),
iii. setup_local_db ( to set up your local database with live on pantheon),

eg. [ php smi.php deploy or ./smi.php setup ]
");
}


# Exec
options($argc, $argv);
