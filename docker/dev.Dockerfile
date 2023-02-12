FROM debian:buster
MAINTAINER André Scholz <info@rothaarsystems.de>
ENV DEBIAN_FRONTEND=noninteractive

RUN apt-get update && apt-get install -y mc zip pv nano \
    tcptrack apache2 sudo ssh curl wget pv -y \
    lsb-release apt-transport-https ca-certificates
RUN wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
RUN echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | sudo tee /etc/apt/sources.list.d/sury-php.list
RUN apt-get update
RUN apt-get install -y php8.1 php8.1-common php8.1-cli php8.1-fpm php-xml \
                php8.1-curl php8.1-gd php8.1-dev php8.1-imap php8.1-intl php8.1-mbstring php8.1-mysql php8.1-xml php8.1-zip \
            php8.1-imagick libapache2-mod-php8.1 php-mysql
RUN wget -qO composer-setup.php https://getcomposer.org/installer
RUN php composer-setup.php --install-dir=/usr/bin --filename=composer
# copy standard stuff
RUN mkdir -p /home/swap && chmod 0777 /home/swap
EXPOSE 8000 80
RUN echo "#!/bin/bash \n\
    declare -x HOST_IP_DOCKER=$(ip r | awk '/default/{print $3}') \n\
    php -S 0.0.0.0:8000 -t /var/www/html/public \n\
    " >> /bin/entrypoint.sh
RUN chmod +x /bin/entrypoint.sh
# change php setting for update and composer
RUN sed -i -e '/memory_limit =/ s/= .*/= 256M/' /etc/php/8.1/cli/php.ini
RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | sudo -E bash
RUN apt-get install symfony-cli -y
ENTRYPOINT ["/bin/entrypoint.sh"]
