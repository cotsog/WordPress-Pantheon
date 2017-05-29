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
      case 'vvv':
          vvv();
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
}

# takes care of user error to default
function default_handler(){


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
To execute this script
Your options are :
'deploy',
'setup' ( to set up your local env),
'setup_local_db' ( to set up your local database with live on pantheon),

eg. [ php smi.php deploy ] ");
}


# Exec
options($argc, $argv);
