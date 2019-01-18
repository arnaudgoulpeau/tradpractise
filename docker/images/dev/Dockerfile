FROM phpbase

RUN yum -y --setopt=tsflags=nodocs --nogpgcheck install openssl php72u-dbg git mysql

WORKDIR /srv

COPY wait-for-mariadb.sh /srv
RUN chmod +x /srv/wait-for-mariadb.sh

WORKDIR /srv/app

COPY init.sh /srv/init.sh
RUN chmod +x /srv/init.sh

CMD /srv/init.sh