FROM i386/ubuntu:xenial AS builder

RUN apt-get update && apt-get install -yq build-essential
WORKDIR /app/src
COPY src ./
RUN cd license && make
RUN cd admin && make
RUN cd admin_panel && make

FROM i386/ubuntu:xenial

# ARG FLAG1
# ARG FLAG2
# ARG FLAG3

ADD ./v1.2.tar.gz /opt/peda/

RUN useradd -ms /bin/bash sbadmin \
    # && echo "sbadmin:${FLAG1}" | chpasswd \
    && useradd -ms /bin/bash admin \
    # && echo "admin:${FLAG2}" | chpasswd \
    && apt-get update \
    && apt-get install -yq openssh-server apache2 php libapache2-mod-php php-pdo php-sqlite3 sudo python python3 build-essential gdb vim nano \
    # git \
    && apt-get clean \
    && chown www-data:www-data /var/www \
    # && git clone https://github.com/longld/peda.git /opt/peda \
    && echo "source /opt/peda/peda-1.2/peda.py" >> /home/sbadmin/.gdbinit \
    && echo "source /opt/peda/peda-1.2/peda.py" >> /home/admin/.gdbinit


COPY init.d /init.d
COPY cfg/sudoers /etc/sudoers
COPY webapp/ /var/www/html/

WORKDIR /var/www/html

COPY --from=builder /app/src/license/build/license /var/www/html
COPY --from=builder /app/src/admin/build/admin /home/sbadmin/bin/admin
COPY --from=builder /app/src/admin_panel/build/admin_panel* /home/admin/bin/

RUN chown admin:admin /home/sbadmin/bin/* \
    && chmod +s /home/sbadmin/bin/admin \
    && chown root:root /home/admin/bin/* \
    && chmod +s /home/admin/bin/admin_panel \
    && chmod +s /home/admin/bin/admin_panel_rop \
    && chown root:root /var/www/html/license \
    && chmod +s /var/www/html/license

CMD ["/init.d/start.sh"]
