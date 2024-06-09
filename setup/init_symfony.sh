#!/bin/bash
set -e

# Navigate to the application directory
cd /opt/dyploma/
INIT_MARKER=".initialized"

if [ ! -f "$INIT_MARKER" ]; then
  echo "First-time initialization..."cd /
    composer update
    # Run Symfony commands
    symfony console doctrine:database:create
    symfony console doctrine:migrations:migrate --no-interaction
    symfony console doctrine:fixtures:load --no-interaction
    touch "$INIT_MARKER"
else
    echo "Already initialized."
fi

# Stop symfony and clean cache
symfony server:stop
symfony console cache:clear
symfony server:start --no-tls --port=8000 --allow-http --daemon

/usr/bin/sleep infinity
