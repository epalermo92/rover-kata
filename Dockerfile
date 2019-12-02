FROM php:7.4-cli
COPY . /usr/src/rover-kata
WORKDIR /usr/src/rover-kata
CMD [ "php", "./index.php" ]
