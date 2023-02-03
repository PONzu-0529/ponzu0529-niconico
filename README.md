# ponzu0529-tools

## How to use this in Xserver

1. Clone this repository

    ```bash
    $ cd $HOME/{{ YOUR_DOMAIN }}/repos
    $ git clone https://github.com/PONzu-0529/ponzu0529-tools.git {{ YOUR_SUBDOMAIN }}
    ...
    $ cd {{ YOUR_SUBDOMAIN }}
    ```

1. Install Nodebrew

    ```bash
    $ curl -L git.io/nodebrew | perl - setup
    ...
    $ echo 'export PATH=$HOME/.nodebrew/current/bin:$PATH' >> ~/.bashrc
    $ source ~/.bashrc
    ```

1. Install Node.js

    ```bash
    $ nodebrew install v16.19.0
    ...
    $ nodebrew use v16.19.0
    ```

1. Install yarn (Custom)

    ```bash
    $ npm install -g yarn
    ```

1. Install packages of Node.js

    ```bash
    $ yarn
    ```

1. Build

    ```bash
    $ yarn build
    ```

1. Set link

    ```bash
    $ ln -s $HOME/{{ YOUR_DOMAIN }}/repos/{{ YOUR_SUBDOMAIN }}/dist $HOME/{{ YOUR_DOMAIN }}/public_html/{{ YOUR_SUBDOMAIN }}
    ```
