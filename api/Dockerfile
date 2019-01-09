FROM ubuntu:16.04

COPY ./infrastructure/crontab /etc/cron.d
RUN chmod -R 644 /etc/cron.d

RUN apt-get update
RUN apt-get install -y software-properties-common python-software-properties
RUN LC_ALL=C.UTF-8 add-apt-repository ppa:ondrej/php
RUN apt-get update -y
RUN apt-get install -y curl php7.2-cli git nginx php7.2-fpm php7.2-intl php7.2-mysql php7.2-mbstring php7.2-zip php7.2-xml
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN rm /etc/nginx/sites-enabled/default
RUN rm /etc/nginx/sites-available/default

COPY ./infrastructure/nginx/sites /etc/nginx/sites-available
COPY ./infrastructure/nginx/nginx.conf /etc/nginx/

RUN sed -i -- "s/max_execution_time = 30/max_execution_time = 300/g" /etc/php/7.2/fpm/php.ini
RUN sed -i -- "s/max_input_time = 60/max_input_time = 600/g" /etc/php/7.2/fpm/php.ini
RUN sed -i -- "s/post_max_size = 8M/post_max_size = 64M/g" /etc/php/7.2/fpm/php.ini
RUN sed -i -- "s/upload_max_filesize = 2M/upload_max_filesize = 32M/g" /etc/php/7.2/fpm/php.ini

WORKDIR /var/www

COPY ./startup.sh /opt/startup.sh
RUN sed -i 's/\r//g' /opt/startup.sh
CMD ["/bin/bash", "/opt/startup.sh"]

EXPOSE 80
