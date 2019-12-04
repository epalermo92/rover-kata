FROM php:7.4-cli
COPY . /usr/src/marsrover
WORKDIR /usr/src/marsrover
CMD [ "php", "./index.php" ]
