#!/usr/bin/php -q
<?php
###############################################################
#                     Setup script
# to run script call : <scriptname> <sitename> <action>
#                 eg : strathcom_conf.php strathcom-cms deploy
###############################################################
###############################################################

# Constants
#define("USER", " ");
#define("MAXSIZ", 100);

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
          default_handler();
    }

}
# deploy
# run merge to production from master
function deploy() {
  echo "\n";
  echo "Setting up deploy...\n";
  sleep(7);
  echo "\n";
  $output = `chmod 755 deploy.sh`;
  $output = `./deploy.sh`;
}

# Prepare dev and test environments
# on Pantheon for tests
# runs the unify-env script
function setup_env(){

  echo "\n";
  echo "Setting up for unifying test and dev to match the live site...\n";
  echo "\n";

  $output = `chmod 755 unify-env.sh`;
  $output_ = `./unify-env.sh`;


}

# Setup local VVV
function setup_local() {


}

function test() {

echo 'hit test! ';
echo "\n";
}

# takes care of user error to default
function default_handler(){
  echo "Your options are :
  'deploy',
  'setup' ( to set up your local env),
  'setup_local_db' ( to set up your local database with live on pantheon),
    ";

  $handle = fopen ("php://stdin","r");

  echo "Insert new command : ";
  sleep(3);

  $line = trim(fgets($handle));
  $sol[1] = $line;
  options('false' , $sol);

#  if(trim($line) != 'yes'){
#     echo "ABORTING!\n";
#     exit;
#  }

}



    # Exec
    options($argc, $argv);
