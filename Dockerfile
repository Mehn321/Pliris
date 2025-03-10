# syntax=docker/dockerfile:1

# Comments are provided throughout this file to help you get started.
# If you need more help, visit the Dockerfile reference guide at
# https://docs.docker.com/go/dockerfile-reference/

# Want to help us make this template better? Share your feedback here: https://forms.gle/ybq9Krt8jtBL3iCk7

################################################################################

# Create a stage for installing app dependencies defined in Composer.
FROM composer:lts as deps

WORKDIR /app

# If your composer.json file defines scripts that run during dependency installation and
# reference your application source files, uncomment the line below to copy all the files
# into this layer.
# COPY . .

# Download dependencies as a separate step to take advantage of Docker's caching.
# Leverage a bind mounts to composer.json and composer.lock to avoid having to copy them
# into this layer.
# Leverage a cache mount to /tmp/cache so that subsequent builds don't have to re-download packages.
RUN --mount=type=bind,source=composer.json,target=composer.json \
    --mount=type=bind,source=composer.lock,target=composer.lock \
    --mount=type=cache,target=/tmp/cache \
    composer install --no-dev --no-interaction

################################################################################

# Create a new stage for running the application that contains the minimal
# runtime dependencies for the application. This often uses a different base
# image from the install or build stage where the necessary files are copied
# from the install stage.
#
# The example below uses the PHP Apache image as the foundation for running the app.
# By specifying the "8.2.12-apache" tag, it will also use whatever happens to be the
# most recent version of that tag when you build your Dockerfile.
# If reproducibility is important, consider using a specific digest SHA, like
# php@sha256:99cede493dfd88720b610eb8077c8688d3cca50003d76d1d539b0efc8cca72b4.
FROM php:8.0-apache

# Install mysqli extension
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Enable Apache rewrite module
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html
# Use the default production configuration for PHP runtime arguments, see
# https://github.com/docker-library/docs/tree/master/php#configuration
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Copy the app dependencies from the previous install stage.
COPY --from=deps app/vendor/ /var/www/html/vendor
# Copy the app files from the app directory.
COPY . /var/www/html/

# Switch to a non-privileged user (defined in the base image) that the app will run under.
# See https://docs.docker.com/go/dockerfile-user-best-practices/
USER www-data
