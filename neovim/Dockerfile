FROM ubuntu:14.04

RUN apt-get update && apt-get install -y software-properties-common && \
    add-apt-repository ppa:neovim-ppa/unstable && apt-get update && \
    apt-get install -y neovim

ENTRYPOINT ["nvim"]
