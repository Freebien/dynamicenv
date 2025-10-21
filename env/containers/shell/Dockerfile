FROM debian:latest AS builder
RUN apt update && apt install -yq gcc-multilib make && apt clean
WORKDIR /build
COPY bins/ ./
RUN ["bash", "./build.sh"]
RUN ls dist

FROM debian:latest
RUN apt update && apt install -y bash openssh-server && apt clean
RUN mkdir /var/run/sshd
RUN apt update \
    && apt install -yq \
        curl wget python3 gdb gcc make gcc-multilib \
        netcat-traditional perl \
        tmux sudo \
        vim nano \
        iputils-ping \
    && apt clean
COPY --from=builder --chmod=4555 /build/dist/ /opt/binaries/
COPY --chmod=555 init.sh /etc/init.d/init.sh
EXPOSE 22
ENTRYPOINT ["/etc/init.d/init.sh"]
