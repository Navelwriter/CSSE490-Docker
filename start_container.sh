#!/bin/bash
#
IMAGE_NAME=zestrada/esec
docker run -it --rm -v $(pwd)/share:/share -w /share $IMAGE_NAME bash
