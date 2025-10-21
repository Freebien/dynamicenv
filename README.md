# Auto env

## Purpose

Auto create self environments for multiple users

## Installation

### Install Docker
You need to install docker : https://docs.docker.com/engine/install/

### Docker Swarm
Initialize docker swarm

```
docker swarm init
```

### Start the lb service
You have to set the secrets and change the domain name in the config

lb/config/traefik.yml

and add the secrets needed in lb/secrets

```
cd lb
docker stack deploy -c docker-compose.yml lb
```

