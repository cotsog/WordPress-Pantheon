#!/usr/bin/env bash
# Author merenuou@gmail.com

set -e # Exit with nonzero exit code if anything fails

SOURCE_BRANCH="testGulp1"
TARGET_BRANCH="testGulp2"


# Pull requests and commits to other branches shouldn't try to deploy, just build to verify
# if [ "$TRAVIS_PULL_REQUEST" != "false" -o "$TRAVIS_BRANCH" != "$SOURCE_BRANCH" ]; then
#     echo "Skipping deploy; just doing a build."
#     # Build here or below
#     #gulp
#     exit 0
# fi

# Save some useful information
REPO=`git config remote.origin.url`
SSH_REPO=${REPO/https:\/\/github.com\//git@github.com:}
SHA=`git rev-parse --verify HEAD`

# Create a new empty branch if gh-pages doesn't exist yet (should only happen on first deply)
git clone $REPO smi_
cd smi_
git checkout $TARGET_BRANCH || git checkout --orphan $TARGET_BRANCH

# Clean smi_ existing contents
rm -rf smi_/**/* || exit 0

ls -l
echo "line 45"
pwd

# step into the assets folder
cd wp-content/themes/strathcom/assets

ls -l

# Install gulp and dependencies
npm install global gulp-cli
npm install -g gulp
sudo npm i -g npm-check-updates
npm-check-updates -u
rm -r node_modules
npm install

# Run gulp  Build here or above
gulp

ls

git config user.name "Travis CI"
git config user.email "merenuou@yahoomail.com"

# If there are no changes (e.g. this is a README update) then just bail.
if [ -z `git diff --exit-code` ]; then
    echo "No changes to the spec on this push; exiting."
    exit 0
fi

# Commit the "changes", i.e. the new version.
# The delta will show diffs between new and old versions.
git add .
git commit -m "Deploy to branch: ${SHA}"

# Get the deploy key by using Travis's stored variables to decrypt github_deploy_key.enc
ENCRYPTED_KEY_VAR="encrypted_${ENCRYPTION_LABEL}_key"
ENCRYPTED_IV_VAR="encrypted_${ENCRYPTION_LABEL}_iv"
ENCRYPTED_KEY=${!ENCRYPTED_KEY_VAR}
ENCRYPTED_IV=${!ENCRYPTED_IV_VAR}
openssl aes-256-cbc -K $ENCRYPTED_KEY -iv $ENCRYPTED_IV -in github_deploy_key.enc -smi_ github_deploy_key -d
chmod 600 github_deploy_key
eval `ssh-agent -s`
ssh-add github_deploy_key

# Now that we're all set up, we can push.
git push $SSH_REPO $TARGET_BRANCH
