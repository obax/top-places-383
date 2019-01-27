#!/usr/bin/env bash

yarn install
yarn build
php bin/console doctrine:migrations:migrate -n
echo "Release job complete"