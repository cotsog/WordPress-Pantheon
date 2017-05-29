#!/usr/bin/php -q
<?php
###############################################################
#                     Setup script
# to run script call : <scriptname> <sitename> <action>
#                 eg : strathcom_conf.php strathcom-cms deploy
###############################################################
###############################################################

# Constants
#define("USER", "Welcome !");
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
  echo "\n";
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

  //   if(trim($line) != 'yes'){
  //      echo "ABORTING!\n";
  //      exit;
  //   }
}
// $out = shell_exec(cd ../);
// var_dump($out);
// //
// $output = shell_exec('git status');
// echo "<pre>$output</pre>";

// $i = 0;
//
// while ( $i < 140 ) {
//   // Write some output
//   fwrite(STDOUT, $i."-");
//   sleep(5);
//   $i++;
//  }

//   echo "Are you sure you want to do this?  Type 'yes' to continue: ";
//
//   $handle = fopen ("php://stdin","r");
//   $line = fgets($handle);
//
function test(){
  echo "test hit";
}

# takes care of user error to default
function default_handler(){
  echo "Your options are :<pre>
  'deploy',
  'setup' ( to set up your local env),
  'setup_local_db' ( to set up your local database with live on pantheon),
  </pre> ";

  $handle = fopen ("php://stdin","r");
  $line = fgets($handle);

  options($line);

#  if(trim($line) != 'yes'){
#     echo "ABORTING!\n";
#     exit;
#  }

}



    # Exec
    options($argc, $argv);
