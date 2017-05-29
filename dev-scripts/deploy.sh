#!/usr/bin/env bash
# Author merenuou@gmail.com

set -e # Exit with nonzero exit code if anything fails

MASTER_BRANCH="master"
SOURCE_BRANCH="testGulp1"
TARGET_BRANCH="testGulp2"
RELEASE_ENG=""

# Save some useful information
REPO=`git config remote.origin.url`
SSH_REPO=${REPO/https:\/\/github.com\//git@github.com:}
SHA=`git rev-parse --verify HEAD`

# Pull requests and commits to other branches shouldn't try to deploy, just build to verify
# if [ "$TRAVIS_PULL_REQUEST" != "false" -o "$TRAVIS_BRANCH" != "$SOURCE_BRANCH" ]; then
#     echo ""
#     exit 0
# fi
# Create a new empty branch if it doesn't exist yet
git checkout $SOURCE_BRANCH
echo `git status --porcelain`
# If there are commits to be made.
if [ -z`git status --porcelain` ]; then
echo "You have uncommited local changes, please stash or commit them; exiting."
exit 0
fi

git pull
git fetch -p
git checkout $TARGET_BRANCH || git checkout --orphan $TARGET_BRANCH

# If there are no changes (e.g. this is a README update) then just bail.
if [ -z `git diff --exit-code` ]; then
echo "No changes to the spec on this push; exiting."
exit 0
fi


git pull
git fetch -p
git merge $SOURCE_BRANCH
git config user.name "CI"
git config user.email "merenuou@yahoomail.com"

# Commit the "changes", i.e. the new version.
# The delta will show diffs between new and old versions.
git add .
git commit -m "Deploy to branch: ${SHA}"


# Get the deploy key by using Travis's stored variables to decrypt github_deploy_key.enc
ENCRYPTED_KEY_VAR="encrypted_${ENCRYPTION_LABEL}_key"
ENCRYPTED_IV_VAR="encrypted_${ENCRYPTION_LABEL}_iv"
ENCRYPTED_KEY=${!ENCRYPTED_KEY_VAR}
ENCRYPTED_IV=${!ENCRYPTED_IV_VAR}
openssl aes-256-cbc -K $ENCRYPTED_KEY -iv $ENCRYPTED_IV -in github_deploy_key.enc -out github_deploy_key -d
chmod 600 github_deploy_key
eval `ssh-agent -s`
ssh-add github_deploy_key

# Now that we're all set up, we can push.
git push $SSH_REPO $TARGET_BRANCH

echo "Done."
