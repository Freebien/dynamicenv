FROM registry.gitlab.com/freeloorax/cours:tpbin
USER root
RUN apt-get update && apt-get install -y openssh-server && apt-get clean
RUN apt-get update && apt-get install -yq netcat-traditional perl && apt-get clean
RUN apt-get update && apt-get install -yq sudo && apt-get clean
RUN usermod -aG sudo etudiant
RUN mkdir /var/run/sshd
RUN chown root:root /home/etudiant/niveau4/*
RUN chmod +s /home/etudiant/niveau4/*
EXPOSE 22
COPY --chmod=555 init.sh /etc/init.d/init.sh
ENTRYPOINT ["/etc/init.d/init.sh"]
