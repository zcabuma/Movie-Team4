FROM php:7.4-apache
RUN docker-php-ext-install mysqli
RUN apt-get install -y memcached

# Default Memcached run command arguments
CMD ["-m", "128"]

# Set the user to run Memcached daemon
USER daemon

# Set the entrypoint to memcached binary
ENTRYPOINT memcached