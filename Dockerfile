FROM php:7.4.1-fpm

COPY setup/shell/install-composer.sh /scripts/
COPY setup/shell/run.sh /scripts/
COPY setup/shell/db_check.sh /scripts/
COPY setup/conf/nginx/nginx.conf /etc/nginx/conf.d/default.conf
COPY setup/cert/ /etc/nginx/

RUN apt-get update \
  && apt-get install -y wget git unzip libpq-dev \
  && : 'Install Node.js' \
  &&  curl -sL https://deb.nodesource.com/setup_12.x | bash - \
  && apt-get install -y nodejs \
  && : 'Install PHP Extensions' \
  && docker-php-ext-install -j$(nproc) pdo_mysql \
  && : 'Install Composer' \
  && chmod 755 /scripts/install-composer.sh \
  && /scripts/install-composer.sh \
  && mv composer.phar /usr/local/bin/composer \
  && git clone https://github.com/phpredis/phpredis.git /usr/src/php/ext/redis \
  && docker-php-ext-install redis \
  && apt-get install -y openssl \
  nginx \
  vim \
  procps \
  mariadb-client \
  && chmod -R 755 /scripts \
  && chmod 400 /etc/nginx/server.key

  #&& sed -i'.bak' 's/^#rc_sys=""/rc_sys="lxc"/' /etc/rc.conf \
  #&& sed -i 's/^#rc_provide="!net"/rc_provide="loopback net"/' /etc/rc.conf \
  #&& sed -i'.bak' '/getty/d' /etc/inittab \
  #&& sed -i'.bak' 's/mount -t tmpfs/# mount -t tmpfs/' /lib/rc/sh/init.sh \
  #&& sed -i'.bak' 's/hostname $opts/# hostname $opts/' /etc/init.d/hostnamez \
  #&& sed -i'.bak' 's/cgroup_add_service$/# cgroup_add_service/' /lib/rc/sh/openrc-run.sh \
  #&& mkdir /run/openrc \
  #&& touch /run/openrc/softlevel \
  #&& rc-status \
  #&& rc-service nginx checkconfig \
  #&& rc-update add nginx

# 自己証明書を発行
# RUN openssl genrsa 2048 > server.key \
#  && openssl req -new -key server.key -subj "/C=JP/ST=Tokyo/L=Chuo-ku/O=RMP Inc./OU=web/CN=localhost" > server.csr \
#  && openssl x509 -in server.csr -days 3650 -req -signkey server.key > server.crt \
#  && cp server.crt /etc/nginx/server.crt \
#  && cp server.key /etc/nginx/server.key \
#  && chmod 400 /etc/nginx/server.key

WORKDIR /var/www/localhost

ENTRYPOINT ["/scripts/run.sh"]
