FROM php:7.0-apache
COPY src/ /var/www/html

RUN apt-get update -y && apt-get install python3 -y
RUN apt-get install cl-base64 -y

COPY src/config/php.ini /usr/local/etc/php/php.ini
RUN useradd -ms /bin/bash prithivi

RUN mv /var/www/html/config/flag.txt /home/prithivi/
RUN chown prithivi /home/prithivi/flag.txt
RUN chown prithivi /usr/bin/base64

USER prithivi
RUN chmod 400 /home/prithivi/flag.txt

USER www-data
EXPOSE 80