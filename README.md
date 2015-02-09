neovim-php
==========

# What ?

A php 5.4+ library that talks to neovim through msgpack.

# Why ?

To provide a base abstraction arounf the neovim's msgpack API,  
that can be used to implement async neovim plugins.

# How ?

    # launch a neovim instance
    NVIM_LISTEN_ADDRESS=/tmp/nvim nvim

    # send commands to it:
    NVIM_LISTEN_ADDRESS=unix:///tmp/nvim php command.php "e file.txt"
    NVIM_LISTEN_ADDRESS=unix:///tmp/nvim php command.php "vsplit"
    NVIM_LISTEN_ADDRESS=unix:///tmp/nvim php command.php "bd"


    # subscribe to server sent events:
    NVIM_LISTEN_ADDRESS=unix:///tmp/nvim php subscribe.php "BufWrite"

