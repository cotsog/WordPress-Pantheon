# clone livesite  to test[staging] environment on pantheon
# Bash script: Search/replace production to test url (multisite compatible)
#!/bin/bash

SITE="otestsite"
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

TOKEN=$(cat /home/vagrant/.terminus-machine-token)

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
terminus remote:wp ${SITE}.${ENV_T} -- cache flush
terminus remote:wp ${SITE}.${ENV_D} -- cache flush
