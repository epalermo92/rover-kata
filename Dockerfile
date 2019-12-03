FROM php:7.4-cli
COPY . /usr/src/rover
WORKDIR /usr/src/rover
CMD [ "php", "./index.php" ]
