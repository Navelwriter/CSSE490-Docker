#!/bin/bash
#second shell in container
IMAGE_NAME=zestrada/esec

#look up running container with IMAGE_NAME
CONTAINER_ID=$(docker ps | grep $IMAGE_NAME | awk '{print $1}')

docker exec -it $CONTAINER_ID bash
