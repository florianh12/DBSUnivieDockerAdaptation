# Mostly AI generated, with a few tweaks from me, to fix compilation errors
FROM php:8.0-apache

RUN apt-get update && apt-get install -y \
    libaio1 \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Copy Oracle Instant Client files from local directory
COPY instantclient-basiclite-linux.x64-23.4.0.24.05.zip /opt/oracle/
COPY instantclient-sdk-linux.x64-23.4.0.24.05.zip /opt/oracle/
# COPY src/ /var/www/html/

# Install Oracle Instant Client
RUN cd /opt/oracle \
    && unzip -o instantclient-basiclite-linux.x64-23.4.0.24.05.zip \
    && unzip -o instantclient-sdk-linux.x64-23.4.0.24.05.zip \
    && rm instantclient-basiclite-linux.x64-23.4.0.24.05.zip \
    && rm instantclient-sdk-linux.x64-23.4.0.24.05.zip \
    && cd instantclient_23_4 \
    && ln -sf libclntsh.so.23.1 libclntsh.so \
    && ln -sf libocci.so.23.4 libocci.so \
    && ln -sf libclntshcore.so.23.4 libclntshcore.so

# Set Oracle environment variables
ENV ORACLE_HOME=/opt/oracle/instantclient_23_4
ENV LD_LIBRARY_PATH=$ORACLE_HOME
ENV PATH=$PATH:$ORACLE_HOME

# Install OCI8 PHP extension
RUN docker-php-ext-configure oci8 --with-oci8=instantclient,$ORACLE_HOME \
    && docker-php-ext-install oci8

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set the working directory
WORKDIR /var/www/html
