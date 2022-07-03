# TeleSend

A simple web app to send data from a web form as chat message by a Telegram bot.

## Installation

1. Clone this repository

    ```bash
    git clone https://github.com/devmount/tele-send
    ```

2. Install dependencies

    ```bash
    composer install
    ```

3. Rename example environment file and set permission mode

    ```bash
    mv .env.example .env
    chmod 400 .env
    ```

4. Fill in the required bot token and chat id of the chat, the form data should be posted in by the bot.
5. Rename example configuration file

    ```bash
    mv config.example.json config.json
    ```

6. Modify configuration to your needs, all possible values are documented in the `config.example.json` file
7. Serve files by a web server
