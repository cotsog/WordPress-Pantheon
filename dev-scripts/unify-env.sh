# clone livesite  to test[staging] environment on pantheon
# Bash script: Search/replace production to test url (multisite compatible)
#!/bin/bash

SITE="otestsite"
SOURCE_URL='live-s.pantheonsite.io'
TEST_SITE_URL='test-s.pantheonsite.io'
DEV_SITE_URL='dev-s.pantheonsite.io'
ENV_L='live'
ENV_T='test'
ENV_D='dev'

echo "This is your site_name: '${SITE}'"

# Check presence of terminus
which terminus > /dev/null 2>&1

if [ 0 -ne $? ] ; then
    echo ""
    echo "WARN: terminus not in env, installing...."
    echo ""
    curl -O https://raw.githubusercontent.com/pantheon-systems/terminus-installer/master/builds/installer.phar && php installer.phar install > /dev/null 2>&1
    alias terminus='/usr/local/bin/terminus'
fi

# terminus wp strathcom-cms.test -- search-replace <old_url> <new_url>  --url=<old_url> --network
# terminus remote:wp ${SITE}.${ENV_T} -- search-replace ${SOURCE_URL} ${DESTINATION_URL} --url=${SOURCE_URL} --network
# terminus wp strathcom-cms.dev -- search-replace live-strathcom-cms.pantheonsite.io dev-strathcom-cms.pantheonsite.io --url=live-strathcom-cms.pantheonsite.io --network


# terminus wp ${SITE}.${ENV_T} -- search-replace ${SOURCE_URL} ${TEST_SITE_URL} --url=${SOURCE_URL} --network
# terminus wp ${SITE}.${ENV_D} -- search-replace ${SOURCE_URL} ${DEV_SITE_URL} --url=${SOURCE_URL} --network



#TOKEN=$(cat /home/vagrant/.terminus-machine-token)

if [ -z TOKEN ]; then
    echo ""
    echo "Get a machine token here  https://dashboard.pantheon.io/users/66a8f4b3-585f-48e2-847d-d479b0d03991#account"
    read -p "Whats your pantheon machine token ?" TOKEN
    echo ""
    echo ${TOKEN} >> /home/vagrant/.terminus-machine-token
fi

# Auth into terminus
terminus auth:login --machine-token=${TOKEN}

# CLONE CONTENT FROM LIVE ENVIRONMENT
terminus env:clone-content ${SITE}.${ENV_L} ${ENV_T}
terminus env:clone-content ${SITE}.${ENV_L} ${ENV_D}

# FLUSH ENVIRONMENTS
wp cache flush
terminus wp strathcom-cms.dev -- cache flush
terminus remote:wp ${SITE}.${ENV_T} -- cache flush
terminus remote:wp ${SITE}.${ENV_D} -- cache flush
