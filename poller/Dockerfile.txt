FROM php:8.1.28-fpm

RUN apt-get update 

# Install SSH2 extension
RUN apt-get install -y libssh2-1 libssh2-1-dev
RUN pecl install ssh2 
RUN docker-php-ext-enable ssh2

# Install Postgres PDO extension
RUN apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql

RUN apt-get install -y cron procps

RUN mkdir /scripts
RUN mkdir /scripts/poller
RUN mkdir /scripts/poller/logs

COPY poller/cron_poller.php /scripts/poller/cron_poller.php
COPY .env /scripts/.env
RUN sed -i "s/127.0.0.1:5433/postgres:5432/g" /scripts/.env

# Add cron job into the cron directory
RUN printf "*/5 * * * *  /usr/local/bin/php /scripts/poller/cron_poller.php  2>&1 >> /scripts/poller/logs/poller.log\n" > /scripts/poller/poller-cron

# Give execution rights on the cron job
RUN chmod 0644 /scripts/poller/poller-cron

# Create the log file to be able to run tail
RUN touch /var/log/cron.log

# Apply cron job
RUN crontab /scripts/poller/poller-cron

# Run the command on container startup
CMD ["cron", "-f"]
